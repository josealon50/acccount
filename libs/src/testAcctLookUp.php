<?php
    include_once("./Synchrony/SynchronySoap.php");
    include_once("./Synchrony/SynchronyBody.php");
    include_once("./Synchrony/SynchronyRequest.php");
    include_once("./Synchrony/SynchronyHeader.php");
    include_once("./request/enhancedAcctLkpRequest.php");
    include_once("./param/EnhancedAcctReqParm.php");
    include_once("./response/enhancedAcctLkpResponse.php");

    $client = new SynchronySoap( 'AccountLookupService', "http://schemas.syf.com/service/account/java", "https://iwww.b2bcreditservices.com/AccountLookupService" );
    $header = new SynchronyHeader( "MORFURN01", 'URN01$Test', "");

    $param = new EnhancedAcctReqParm( "", "5348123430000012", "", "3091", "55101", "", "QM", "", "", "", "", "TESTCASE", "TECHSOLUTIONS", "", "2201197501" );
    $request = new enhancedAcctLkpRequest( $param );

    $body = $param->generateSynchronyBody( $request->getOpenRequestTag(), $request->getClosingRequestTag(), $param->getOpenReqParmTag(), $param->getClosingReqParmTag() );

    $client->setHeader($header->generateWsseHeader());
    $client->setBody( $body );
    $xml = $client->generateSynchronyXML();
    var_dump($xml);
    /*
    $url = "https://iwww.b2bcreditservices.com/AccountLookupService";
    $c = $client->call( $url, $client->getXML() );
    var_dump($c);
    */

    try{
        //$c  = new SoapClient( NULL, array( 'soap_version' => SOAP_1_1, 'trace' => true, 'uri' => 'BuyService', 'location' => "https://iwww.b2bcreditservices.com/BuyService" ));
        $args = array(new SoapVar($xml, XSD_ANYXML));    
        //$res  = $c->__soapCall(NULL, $args);
        //var_dump($c->__getLastRequest());
        //var_dump($c->__getLastRequestHeaders());
        //var_dump($c->__getLastResponseHeaders());

        $res = $client->__soapCall( NULL, $args );
        var_dump($res);

    }
    catch( Exception $e ){
        var_dump($e);

    }

    
?>
