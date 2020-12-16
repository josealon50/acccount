<?php

class enhancedAcctLkpResponse
{

    /**
     * @var EnhancedAcctResParm $EnhancedAcctResParm
     * @access public
     */
    public $EnhancedAcctResParm = null;

    /**
     * @param EnhancedAcctResParm $EnhancedAcctResParm
     * @access public
     */
    public function __construct($EnhancedAcctResParm)
    {
      $this->EnhancedAcctResParm = $EnhancedAcctResParm;
    }

}
