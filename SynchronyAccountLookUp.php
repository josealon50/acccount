<?php
    include_once( './config.php' );
    include_once( './libs/IDBResource.php');
    include_once( './libs/IDBTable.php');
    include_once( './libs/IDate.php');
    include_once( './db/CustAsp.php');
    include_once( './db/Cust.php');
    include_once( './db/MorCustAspAppHist.php');
    include_once( './db/MorStoreToAspMerchant.php');
    include_once( './db/ZipCodes.php');
    include_once( './db/CustAspAndSo.php');
    include_once("./libs/src/Synchrony/SynchronySoap.php");
    include_once("./libs/src/Synchrony/SynchronyBody.php");
    include_once("./libs/src/Synchrony/SynchronyRequest.php");
    include_once("./libs/src/Synchrony/SynchronyHeader.php");
    include_once( './libs/AcctLookUp/EnhancedAcctReqParm.php');
    include_once( './libs/AcctLookUp/enhancedAcctLkpRequest.php');
    //require_once("/home/public_html/weblibs/iware/php/utils/IAutoLoad.php");
    require_once("../../public/libs".DIRECTORY_SEPARATOR."iware".DIRECTORY_SEPARATOR."php".DIRECTORY_SEPARATOR."utils".DIRECTORY_SEPARATOR."IAutoLoad.php");

    global $appconfig;
    
    $db = sessionConnect();
    $errors = []; 
    $customersNoAcct = []; 
    $row = null;

    if ( $argc == 4 ){
        $customers = new CustAspAndSo( $db );
        $fromDate = new IDate();
        $fromDate->setDate( $argv[1], IDate::ORACLE_FORMAT );
        $endDate = new IDate();
        $endDate->setDate( $argv[2], IDate::ORACLE_FORMAT );

        //Doing a search by date on SO.PU_DEL_DT
        $where = "WHERE TO_DATE(SO.PU_DEL_DT) >= TO_DATE( '" . $fromDate->toStringOracle() . "', 'dd-mm-yy') AND TO_DATE(SO.PU_DEL_DT) <= TO_DATE( '" . $endDate->toStringOracle() . "', 'dd-mm-yy') AND ACCT_NUM IS NULL AND AS_CD='SYF' AND SO.SO_STORE_CD = '" . $argv[3] . "' ";
        
    }
    else{
        $customers = new CustAsp( $db );
        //$where = "WHERE AS_CD = 'SYF' AND ACCT_NUM IS NULL"; 
        $where = "WHERE CUST_CD = 'RODRC32222'"; 
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
            array_push( $error, [ $row['CUST_CD'], 'No Customer record' ] );
            continue;
        }
        
        if( $cust->next() ){
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
                                callCustAsp( $row['CUST_CD'], $acct );
                            }
                        }
                        else{
                            array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                        }
                    }
                    else{
                        //Call endpoint to create new CUST_ASP record
                        callCustAsp( $row['CUST_CD'], $acct );
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
                                    callCustAsp( $row['CUST_CD'], $acct );
                                }
                            }
                            else{
                                array_push( $customersNoAcct, [ $row['CUST_CD'], $cust->get_FNAME(), $cust->get_LNAME(), $cust->get_HOME_PHONE()] );
                            }
                        }
                        else{
                            //Call endpoint to create new CUST_ASP record
                            callCustAsp( $row['CUST_CD'], $acct );
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
    function callCustAsp( $custCd, $accts ){
        global $appconfig;

        try{ 
            $ch = curl_init( $appconfig['CREATE_CUST_ASP_ENDPOINT'] );

            $limit = 0;
            if ( isset($accts->CreditLimit) ){
                $limit  = ltrim($accts->CreditLimit, '0');
                var_dump($limit);
            }

            $payload = json_encode( array( "CUST_CD"=> $custCd, "ACCT_NUM" => $accts->AccountNumber, "AS_CD" => "SYF", "APP_CREDIT_LINE" => $limit ));
            var_dump($payload);

            curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            
            curl_exec($ch);
            curl_close($ch);

            return true;
        }
        catch( Exception $e ){
            return false;
        }
        
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
?>
