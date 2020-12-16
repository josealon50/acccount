<?php

class enhancedAcctLkpRequest extends SynchronyRequest
{

    /**
     * @var EnhancedAcctReqParm $EnhancedAcctReqParm
     * @access public
     */
    public $EnhancedAcctReqParm = null;

    /**
     * @param EnhancedAcctReqParm $EnhancedAcctReqParm
     * @access public
     */
    public function __construct($EnhancedAcctReqParm)
    {
      $this->EnhancedAcctReqParm = $EnhancedAcctReqParm;
    }

}
