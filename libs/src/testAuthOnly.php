<?php
    include_once("./Synchrony/SynchronySoap.php");
    include_once("./Synchrony/SynchronyBody.php");
    include_once("./Synchrony/SynchronyRequest.php");
    include_once("./Synchrony/SynchronyHeader.php");
    include_once("./param/authonlyParm.php");
    include_once("./request/authorizationOnlyRequest.php");

    $client = new SynchronySoap( 'BuyService', "http://schemas.syf.com/service/buy/java", "https://iwww.b2bcreditservices.com/BuyService" );
    $header = new SynchronyHeader( "MORFURN01", 'URN01$Test', "");  
    $param = new authonlyParm( "6019194600801713", "", "", "", "", "", "5348123430000012", "", "424", "15.00", "", "", "", ""  );
    $request = new authorizationOnlyRequest( $param );

    $body = $param->generateSynchronyBody( $request->getOpenRequestTag(), $request->getClosingRequestTag(), $param->getOpenReqParmTag(), $param->getClosingReqParmTag() );
    $client->setHeader($header->generateWsseHeader());
    $client->setBody( $body );
    $xml = $client->generateSynchronyXML();

    $url = "https://iwww.b2bcreditservices.com/BuyService";

    try{
        $args = array(new SoapVar($xml, XSD_ANYXML));    
        $res = $client->__SoapCall( NULL, $args );
        //var_dump($client->__getLastRequestHeaders());
        //var_dump($client->__getLastResponseHeaders());
        var_dump($res);

    }
    catch( Exception $e ){
        var_dump($e);

    }
    
?>
