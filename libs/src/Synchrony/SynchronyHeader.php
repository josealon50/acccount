<?php

class SynchronyHeader
{
    public $header = null;
    public $username = null;
    public $password = null;

    public function __construct( $username, $password, $header ){
        $this->username = $username;
        $this->password = $password;
        $this->header = $header;
    }

    public function getHeader(){
        return $this->header;
    }
    public function getOpenHeaderTags(){
        return "<soapenv:Header>";
    }
    public function getClosingHeaderTags(){
        return "</soapenv:Header>";
    }
    
    public function setHeader( $header ){
        $this->header = $header;
    }

    public function generateWsseHeader(){
        /* The timestamp. The computer must be on time or the server you are
         * connecting may reject the password digest for security.
         */
        $created = gmdate('Y-m-d\TH:i:s\Z');

        /* A random word. The use of rand() may repeat the word if the server is
         * very loaded.
         */
        $nonce = base64_encode(mt_rand());

        $header = '<wsse:Security soapenvmustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"  xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                     <wsse:UsernameToken>
                                <wsse:Username>' . $this->username . '</wsse:Username>
                                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' .$this->password . '</wsse:Password>
                                <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">' . $nonce . '</wsse:Nonce> 
                                <wsu:Created>' . $created . '</wsu:Created>
                        </wsse:UsernameToken>
                    </wsse:Security>';
        $this->header = $this->getOpenHeaderTags() . $header . $this->getClosingHeaderTags();
        return $this->header;
    }

}

?>
