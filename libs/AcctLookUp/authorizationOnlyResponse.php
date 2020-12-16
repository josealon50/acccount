<?php

class authorizationOnlyResponse
{

    /**
     * @var authonlyResParm $authonlyResParm
     * @access public
     */
    public $authonlyResParm = null;

    /**
     * @param authonlyResParm $authonlyResParm
     * @access public
     */
    public function __construct($authonlyResParm)
    {
      $this->authonlyResParm = $authonlyResParm;
    }

}
