<?php
    include_once( './../config.php' );
    include_once( './autoload.php' );

    spl_autoload_register('SynchronyAutoload');

    global $appconfig;
    
    $db = sessionConnect();
    $errors = []; 
    $customersNoAcct = []; 
    $row = null;

    if ( count($argv) > 1 ){
        if ( $argv[1] == 1 ){
            $customers = new CustAspAndSo( $db );
            $fromDate = new IDate();
            $fromDate->setDate( $argv[2], IDate::ORACLE_FORMAT );
            $endDate = new IDate();
            $endDate->setDate( $argv[3], IDate::ORACLE_FORMAT );

            //Doing a search by date on SO.PU_DEL_DT
            $where = "WHERE TO_DATE(SO.PU_DEL_DT) >= TO_DATE( '" . $fromDate->toStringOracle() . "', 'dd-mm-yy') AND TO_DATE(SO.PU_DEL_DT) <= TO_DATE( '" . $endDate->toStringOracle() . "', 'dd-mm-yy') AND ACCT_NUM IS NULL AND AS_CD='SYF' AND SO.SO_STORE_CD IN (" . $appconfig['synchrony']['PROCESS_STORE_CD'] . " ) ";
            
        }
        else if( $argv[1] == 2 ){
            $customers = new ASPStoreForward($db);
            $where = "WHERE  as_cd = 'SYF' AND store_cd IN ( " . $appconfig['synchrony']['PROCESS_STORE_CD'] . ") AND stat_cd = 'H' AND trunc(create_dt_time) between '" . $appconfig['synchrony']['PROCESS_FROM_DATE'] . "' AND '" . $appconfig['synchrony']['PROCESS_TO_DATE'] . "' ";
        }
    }
    else{
        $customers = new CustAsp( $db );
        $where = "WHERE CUST_CD IN (" . $appconfig['synchrony']['PROCESS_CUST_CDS'] . " ) " ; 
    }

    $error = $customers->query($where);
    if ( $error < 0 ){
        //echo "Error on Query to CUST_ASP: " . $where . "\n";
    }


    while( $row = $customers->next() ){
        echo "PROCESSING CUSTOMER: " . $row['CUST_CD'] . "\n";
            

        //Query Cust table to get phone number
        $cust = new Cust($db);
        $where = "WHERE CUST_CD = '" . $row['CUST_CD'] . "' ";
        $count = $cust->query($where);

        if( $count < 0 ){
            //Customer has no CUST record save him to an error array
            array_push( $customersNoAcct, [ $row['CUST_CD'], '', '', '', 'No Customer record' ] );
            continue;
        }

        
        if( $customer = $cust->next() ){
            echo "VALIDATING DATA FOR CUSTOMER: " . $row['CUST_CD'] . "\n";
            $valid = validateCustomer( $customer );
            
            var_dump( " CUSTOMER VALID: " . $valid );
            if ( !$valid ){
                array_push( $customersNoAcct, [ $customer['CUST_CD'], $customer['FNAME'], $customer['LNAME'], $customer['HOME_PHONE'], 'Invalid Customer Info' ] );
                continue;
                
            }


            //We need to find out where the customer applied for credit if there is no record
            //we might need to use the zip code to find the closest store
            //should be in table MOR_CUST_ASP_HISTORY 
            $custAspHist = new MorCustAspAppHist($db);
            $where = "WHERE CUST_CD = '" . $row['CUST_CD'] . "' AND AS_CD = 'SYF'";  
            $result = $custAspHist->query($where);

            if ( $result < 0 ){
                continue;
            }
            if ( $custAspHist->next() ){
               $merchant = new MorStoreToAspMerchant($db);
               $where = "WHERE STORE_CD = '" . $custAspHist->get_STORE_CD() . "' AND AS_CD = 'SYF'"; 
               $result = $merchant->query($where);

               if( $result < 0 ){
                   //echo "ERROR QUERY ON MOR_STORE2ASP WHERE CLAUSE: . $where\n";
               }

               if( $merchant->next() ){
                    $acct = getAccountNumber( $merchant->get_MERCHANT_NUM(), $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE(), $cust->get_ZIP_CD() );

                    sleep($appconfig['CALL_DELAY']); 
                    if( !isset($acct->AccountNumber) ){
                        //Might need to do a search on bus phone 
                        if( !is_null($cust->get_BUS_PHONE()) ){
                            $acct = getAccountNumber( $merchant->get_MERCHANT_NUM(), $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_BUS_PHONE(), $cust->get_ZIP_CD() );
                            sleep($appconfig['CALL_DELAY']); 

                            if( !isset($acct->AccountNumber) ){
                                //Capture customer we could not find his account number 
                                array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                            }
                            else{
                                //Call endpoint to create new CUST_ASP record
                                callCustAsp( $db, $row['CUST_CD'], $acct );
                            }
                        }
                        else{
                            array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                        }
                    }
                    else{
                        //Call endpoint to create new CUST_ASP record
                        callCustAsp( $db, $row['CUST_CD'], $acct );
                    }
               }
            }
            else{
                //We need to find the closest store with respect to their zip code
                $zip = new ZipCodes($db);
                $where = "WHERE ZIP_CD = '" . $cust->get_ZIP_CD() . "' ";

                $result = $zip->query($where);
                if( $result < 0 ){
                    //echo "ERROR QUERY ZIP_LOCATION_DIST WHERE: $where\n";
                }

                if( $zip->next() ){
                    $merchant = new MorStoreToAspMerchant($db);
                    $where = "WHERE STORE_CD = '" . $zip->get_STORE_CD() . "' AND AS_CD = 'SYF'"; 
                    $result = $merchant->query($where);
                    
                    if ( $merchant->next() ){
                        $acct = getAccountNumber( $merchant->get_MERCHANT_NUM(), $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE(), $cust->get_ZIP_CD() );
                        sleep($appconfig['CALL_DELAY']); 
                        if( !isset($acct->AccountNumber) ){
                            //Might need to do a search on bus phone 
                            if( !is_null($cust->get_BUS_PHONE()) ){
                                $acct = getAccountNumber( $merchant->get_MERCHANT_NUM(), $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_BUS_PHONE(), $cust->get_ZIP_CD() );
                                sleep($appconfig['CALL_DELAY']); 
                                if( !isset($acct->AccountNumber) ){
                                    //Capture customer we could not find his account number 
                                    array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                                }
                                else{
                                    //Call endpoint to create new CUST_ASP record
                                    callCustAsp( $db, $row['CUST_CD'], $acct );
                                }
                            }
                            else{
                                array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                            }
                        }
                        else{
                            //Call endpoint to create new CUST_ASP record
                            callCustAsp( $db, $row['CUST_CD'], $acct );
                        }
                    }
                    else{
                        array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                    }
                }
                else{
                    //Capture customer code customer have incorrect data and no way to 
                    //find out his account number
                    array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                }
            }
        }
    }


    $fp = fopen( "./out/customers_no_acct.csv", 'w+' );
    fwrite( $fp, "CUST_CD,FIRST_NAME,LAST_NAME,PHONE_NUMBER\n");
    //Create a new csv file for customer that we were not able to find their account numbers 
    foreach( $customersNoAcct as $value ){
        fputcsv( $fp, $value );
    }

    function getAccountNumber( $merchantNum, $fname, $lname, $phone, $zipCode ) {
        global $appconfig;

        //Build synchrony request 
        $client = new SynchronySoap( 
            $appconfig['synchrony']['synchrony_services']['acctlookup']['service'], 
            $appconfig['synchrony']['synchrony_services']['acctlookup']['param_namespace']['url'], 
            $appconfig['synchrony']['synchrony_services']['acctlookup']['url'] 
        );

        $header = new SynchronyHeader( $appconfig['synchrony']['user'], $appconfig['synchrony']['password'], "");  
        $param = new EnhancedAcctReqParm (
             ""        //Client
            ,$merchantNum        //MerchantNumber
            ,""        //PartnerCode
            ,""        //Ssn
            ,$zipCode        //ZipCode
            ,""        //ChannelId
            ,$appconfig['synchrony']['product_code']        //ProductCode
            ,""        //CHDPrefix1
            ,""        //CHDPrefix2
            ,""        //CHDPrefix3
            ,""        //CHDPrefix4
            ,$fname       //FirstName
            ,$lname        //LastName
            ,""        //AccountType
            ,str_replace('-', '', $phone)        //PhoneNumber
            
        );

        $acct = null;
        $request = new enhancedAcctLkpRequest( $param );
        $body = $param->generateSynchronyBody( $request->getOpenRequestTag(), $request->getClosingRequestTag(), $param->getOpenReqParmTag(), $param->getClosingReqParmTag() );
        $client->setHeader($header->generateWsseHeader());
        $client->setBody( $body );
        var_dump(tidy_repair_string( $body, ['input-xml'=> 1, 'indent' => 1, 'wrap' => 0] ) . "\n" );
        $xml = $client->generateSynchronyXML();

        try{
            $args = array(new SoapVar($xml, XSD_ANYXML));    
            $response = $client->__SoapCall( NULL, $args );
            var_dump(tidy_repair_string( $client->__getLastResponse(), ['input-xml'=> 1, 'indent' => 1, 'wrap' => 0] ) . "\n" );

            if ($response->ResponseCode == '000' ||  $response->ResponseCode == '101'  ){ 
                if ( isset($response->AccountNumber) ){
                    return $response;
                }
            }
            else{
                switch( $response->ResponseCode ){
                    case '200' :
                    case '300' : 
                    case '400' :
                        if( isset($response->ListOfErrors) ){
                            $responseMsg = $response->ListOfErrors;
                        }
                        else{
                            $responseMsg = $response->ResponseText;
                        }
                    break;
                }

            }            
        }
        catch( SoapFault $e ){
            return null;
        }
        return null;

    }
    function callCustAsp( $db, $custCd, $accts ){
        global $appconfig;

        $encAcctNum = openssl_encrypt($accts->AccountNumber, $appconfig['ciphering'], $appconfig['encryption_key'], $appconfig['options'], $appconfig['encryption_iv']);

        if ( !isset($accts->CreditLimit) ){
            $accts->CreditLimit = 0;
        }
        else{
            $accts->CreditLimit = ltrim($accts->CreditLimit, '0');
        }

        //Check if a record already exists for that customer
        $custAsp = new CustAsp( $db );
        $existingCustAsp = $custAsp->getCustAspByAcctNumAndAsCdAndCustCdAndAcctCd( $custCd, "SYF", substr( $accts->AccountNumber, -4 ), $encAcctNum, '' );
        if( !is_null($existingCustAsp) ){
            echo "Customer: " . $custCd . " already exists \n";
            echo "Encrypted Account Number: " . $encAcctNum . "\n";
            echo "Credit Limit: " . $accts->CreditLimit . "\n";
            return;
            
        }

        //Check if a record exists for that customer  
        $existingCustAsp = $custAsp->getCustAspByCustCdAndAsCd( $custCd, 'SYF', '' );
        if( is_null($existingCustAsp) ){
            echo "Creating Customer: " . $custCd . "\n";
            echo "Encrypted Account Number: " . $encAcctNum . "\n";
            echo "Credit Limit: " . $accts->CreditLimit . "\n";
            
            createCustAsp ($db, $custCd, 'SYF', $accts->AccountNumber, $accts->CreditLimit, '', $encAcctNum);
            return;
        }
        else{
            $where = array( "CUST_CD" => $custCd, "AS_CD" => 'SYF' );
            $updt = array( "ACCT_NUM" => $encAcctNum, "ACCT_CD" => substr( $accts->AccountNumber, -4 ), "APP_CREDIT_LINE" => $accts->CreditLimit ); 

            echo "Updating customer: " . $custCd . "\n";
            var_dump($updt);

            $update = $custAsp->updateCustAsp( $where, $updt );
        }

        
    }

	function createCustAsp ($db, $cust_cd, $finco, $acctnum, $crlimit, $as_ref_no, $encAcctNum = '') {
		global $appconfig;		
		$custAsp = new CustAsp($db);

		$custAsp->set_CUST_CD(strtoupper($cust_cd));
		$custAsp->set_AS_CD($finco);
		$custAsp->set_APP_CREDIT_LINE($crlimit);
		$custAsp->set_APP_REF_NUM($as_ref_no);
        if ( $finco == 'SYF' ){
		    $custAsp->set_ACCT_CD(substr($acctnum, -4));
		    $custAsp->set_ACCT_NUM($encAcctNum);

        }
        else{
		    $custAsp->set_ACCT_CD(substr($acctnum, -10));

        }
		$result = $custAsp->insert(false, false);	

		if ($result == false) {
            return false;
		}

        return true;
	}


    function sessionConnect() {
        global $appconfig;

        $db = new IDBResource($appconfig['dbhost'], $appconfig['dbuser'], $appconfig['dbpwd'],  $appconfig['dbname']);
        
        try {
            $db->open();
        }
        catch (Exception $e) {
            return false; 
        }

        return $db;

    }

    function validateCustomer( $row ){
        //Check if firstname has some special characters 
        if ( preg_match('/[^£$%&*()}{@#~?><>,|=_+¬-]/', $row['FNAME'] )){
            return false;
        }

        if ( preg_match('/[^£$%&*()}{@#~?><>,|=_+¬-]/', $row['LNAME'] )){
            return false;
        }

        return true;
        
    }
?>
