<?php

class SynchronyParameter
{
    public $parameter;
    public $class

    public function __construct( $class, $parameter ){
        $this->class = $class; 
        $this->parameter = "";
    }

    public function getParameter(){
        return $this->parameter;
    }
    
    public function setBody( $parameter ){
        $this->body = $parameter;
    }

    public generateBody(){
        return '';
    }

}

?>
