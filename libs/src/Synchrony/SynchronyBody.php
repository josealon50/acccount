<?php

class SynchronyBody 
{
    public $body;

    public function __construct( $body ){
        $this->body = $body;
    }

    public function getBody(){
        return $this->body;
    }
    public function getOpenBodyTags(){
        return "<soapenv:Body>";
    }
    public function getClosingBodyTags(){
        return "</soapenv:Body>";
    }
    
    public function setBody( $body ){
        $this->body = $body;
    }

    public function generateSynchronyBody( $requestOpen, $requestClose, $paramOpen, $paramClose ){
        $params = $this->getOpenBodyTags() . $requestOpen . $paramOpen;
        foreach( $this->body as $key => $value ){
            if( $value === ''){
                $params .= "<java:" . $key . "/>";
            }
            else{
                $params .= "<java:" . $key . ">" . $value . "</java:" . $key . ">";
            }

        } 
        $params .= $paramClose . $requestClose . $this->getClosingBodyTags();
        
        return $params;
    }

}

?>
