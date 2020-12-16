<?php

    $xml = '<?xml version="1.0" encoding="UTF-8"?> <soapenv:Envelope xmlns:java="http://schemas.syf.com/service/apply/java" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v2="http://schemas.syf.com/services/V2"><soapenv:Header><wsse:Security soapenvmustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"><wsse:UsernameToken><wsse:Username>test</wsse:Username><wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password><wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">MTE4MTc3MTkyMQ==</wsse:Nonce><wsu:Created>2020-01-27T15:51:41Z</wsu:Created></wsse:UsernameToken></wsse:Security></soapenv:Header><soapenv:Body><v2:findAppStatusRequest><v2:creditAppStatusReqParm><java:Client>TEST</java:Client><java:KeyNumber>TEST</java:KeyNumber><java:MerchantNumber>TEST</java:MerchantNumber><java:OperationCode>TEST</java:OperationCode><java:OrginationCode>TEST</java:OrginationCode><java:PartnerCode>TEST</java:PartnerCode><java:ChannelId>TEST</java:ChannelId></v2:creditAppStatusReqParm></v2:findAppStatusRequest></soapenv:Body></soapenv:Envelope>'; 
    $xml = new SimpleXMLElement( $xml );
    $namespaces = $xml->getNamespaces(true);
    var_dump($namespaces);

    var_dump($xml->v2);
    exit();
    $child = $xml->children($namespaces['v2']);
    var_dump("Before child");
    print_r($child, 1);
    var_dump($child);
    foreach( $child as $children ){
        print_r($children, 1);
    }

?>  
