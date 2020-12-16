<?php

class findOpenToBuyResponse
{

    /**
     * @var AccountToBuyResParm $AccountToBuyResParm
     * @access public
     */
    public $AccountToBuyResParm = null;

    /**
     * @param AccountToBuyResParm $AccountToBuyResParm
     * @access public
     */
    public function __construct($AccountToBuyResParm)
    {
      $this->AccountToBuyResParm = $AccountToBuyResParm;
    }

}
