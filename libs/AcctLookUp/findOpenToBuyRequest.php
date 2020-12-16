<?php

class findOpenToBuyRequest extends SynchronyRequest
{

    /**
     * @var AccountToBuyParm $AccountToBuyParm
     * @access public
     */
    public $AccountToBuyParm = null;

    /**
     * @param AccountToBuyParm $AccountToBuyParm
     * @access public
     */
    public function __construct($AccountToBuyParm)
    {
      $this->AccountToBuyParm = $AccountToBuyParm;
    }

}
