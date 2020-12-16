<?php

class SynchronySoap extends SoapClient 
{

    public $envelope;
    public $service;
    public $header;
    public $body;
    public $xml;
    public $client;
    public $namespace;

    public function __construct( $namespace, $service, $url ){
        $this->header = ""; 
        $this->body = "";
        $this->xml =  "";
        $this->service = $service;
        $this->namespace = $namespace;
        $this->url = $url;
        $this->envelope = $this->defaultEnvelope( $service );

        parent::__construct( NULL, 
            array( 
                'soap_version' => SOAP_1_1, 
                'trace' => true, 
                'uri' => $namespace, 
                'location' => $url, 
                'uri' => $namespace, 
            )
        );
    }

    public function getEnvelope(){
        return $this->envelope;
    }
    public function getBody(){
        return $this->body;
    }

    public function getHeader(){
        return $this->header;
    }

    public function setEnvelope( $envelope ){
        $this->envelope = $envelope;
    }
    public function setHeader( $header ){
        $this->header = $header;
    }
    
    public function setBody( $body ){
        $this->body =  $body;
    }
    public function getOpenEnvelopeTags(){
        return "<soapenv:Envelope>";
    }
    public function getClosingEnvelopeTags(){
        return "</soapenv:Envelope>";
    }

    public function getXML(){
        return $this->xml;
    }

    public function generateSynchronyXML(){
        //Append open and closing body, and envelop tags 
        $this->xml = $this->envelope . $this->header . $this->body . $this->getClosingEnvelopeTags(); 

        return $this->xml;
    }

    public function defaultEnvelope( $service ){
        return '<?xml version="1.0" encoding="UTF-8"?><soapenv:Envelope xmlns:java="' . $service . '" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v2="http://schemas.syf.com/services/V2">';
        
    }
    public function call( $url, $xml ){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0) {
        $request = $this->xml;
        return parent::__doRequest($request, $location, $action, $version);

    }

    public function setXml( $xml ){
        var_dump($xml);
        $thix->xml = $xml;
    }

}

?>
