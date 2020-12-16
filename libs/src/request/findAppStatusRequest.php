<?php

class findAppStatusRequest extends SynchronyRequest
{

    /**
     * @var creditAppStatusReqParm $creditAppStatusReqParm
     * @access public
     */
    public $creditAppStatusReqParm = null;

    /**
     * @param creditAppStatusReqParm $creditAppStatusReqParm
     * @access public
     */
    public function __construct($creditAppStatusReqParm)
    {
      $this->creditAppStatusReqParm = $creditAppStatusReqParm;
    }
    


}
