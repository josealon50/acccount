<?php

class creditAppStatusReqParm extends SynchronyBody
{

    /**
     * @var string $Client
     * @access public
     */
    public $Client = null;

    /**
     * @var string $KeyNumber
     * @access public
     */
    public $KeyNumber = null;

    /**
     * @var string $MerchantNumber
     * @access public
     */
    public $MerchantNumber = null;

    /**
     * @var string $OperationCode
     * @access public
     */
    public $OperationCode = null;

    /**
     * @var string $OrginationCode
     * @access public
     */
    public $OrginationCode = null;

    /**
     * @var string $PartnerCode
     * @access public
     */
    public $PartnerCode = null;

    /**
     * @var string $ChannelId
     * @access public
     */
    public $ChannelId = null;


    public $params = null;

    /**
     * @param string $Client
     * @param string $KeyNumber
     * @param string $MerchantNumber
     * @param string $OperationCode
     * @param string $OrginationCode
     * @param string $PartnerCode
     * @param string $ChannelId
     * @access public
     */
    public function __construct($Client, $KeyNumber, $MerchantNumber, $OperationCode, $OrginationCode, $PartnerCode, $ChannelId)
    {
          $this->Client = $Client;
          $this->KeyNumber = $KeyNumber;
          $this->MerchantNumber = $MerchantNumber;
          $this->OperationCode = $OperationCode;
          $this->OrginationCode = $OrginationCode;
          $this->PartnerCode = $PartnerCode;
          $this->ChannelId = $ChannelId;

          $this->params = [  "Client" => $Client ,"KeyNumber" => $KeyNumber ,"MerchantNumber" => $MerchantNumber ,"OperationCode" => $OperationCode ,"OrginationCode" => $OrginationCode ,"PartnerCode" => $PartnerCode ,"ChannelId" => $ChannelId ]; 
          parent::__construct( $this->params );
    }
    public function getOpenReqParmTag(){
        return "<v2:" . get_class($this) . ">";
    }
    public function getClosingReqParmTag(){
        return "</v2:" . get_class($this) . ">";
    }

}

?>
