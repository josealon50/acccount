<?php

class applyPlccRequest
{

    /**
     * @var creditAppPlccReqParm $creditAppPlccReqParm
     * @access public
     */
    public $creditAppPlccReqParm = null;

    /**
     * @param creditAppPlccReqParm $creditAppPlccReqParm
     * @access public
     */
    public function __construct($creditAppPlccReqParm)
    {
      $this->creditAppPlccReqParm = $creditAppPlccReqParm;
    }

}
