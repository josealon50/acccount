<?php

class SynchronyRequest 
{
    public $request;

    public function __construct( $param ){
        $this->request = $param;
    }

    public function getRequest(){
        return $this->request;
    }
    
    public function setRequest( $request ){
        $this->body = $body;
    }
    public function getOpenRequestTag(){
        return "<v2:" . get_class($this) . ">";
    }
    public function getClosingRequestTag(){
        return "</v2:" . get_class($this) . ">";
    }
}

?>
