<?php
    include_once("WsseAuthHeader.php");
    include_once("SynchronySoap.php");
    include_once("SynchronyBody.php");
    include_once("SynchronyRequest.php");
    include_once("SynchronyHeader.php");
    include_once("./request/findAppStatusRequest.php");
    include_once("./param/creditAppStatusReqParm.php");

    $client = new SynchronySoap();
    $header = new SynchronyHeader( "test", "password", "");

    $param = new creditAppStatusReqParm( "TEST", "TEST", "TEST", "TEST", "TEST", "TEST", "TEST" );
    $request = new findAppStatusRequest( $param );

    $body = $param->generateSynchronyBody( $request->getOpenRequestTag(), $request->getClosingRequestTag(), $param->getOpenReqParmTag(), $param->getClosingReqParmTag() );

    $client->setHeader($header->generateWsseHeader());
    $client->setBody( $body );
    $client->generateSynchronyXML();

    var_dump($client);
    
?>
