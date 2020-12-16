<?php

class ListOfErrors
{

    /**
     * @var string $Error
     * @access public
     */
    public $Error = null;

    /**
     * @param string $Error
     * @access public
     */
    public function __construct($Error)
    {
      $this->Error = $Error;
    }

}
