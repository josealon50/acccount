<?php

class authorizationOnlyRequest
{

    /**
     * @var authonlyParm $authonlyParm
     * @access public
     */
    public $authonlyParm = null;

    /**
     * @param authonlyParm $authonlyParm
     * @access public
     */
    public function __construct($authonlyParm)
    {
      $this->authonlyParm = $authonlyParm;
    }

}
