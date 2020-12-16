<?php

class AccountToBuyParm extends SynchronyBody
{

    /**
     * @var string $AccountNumber
     * @access public
     */
    public $AccountNumber = null;

    /**
     * @var string $Client
     * @access public
     */
    public $Client = null;

    /**
     * @var string $MerchantNumber
     * @access public
     */
    public $MerchantNumber = null;

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

    /**
     * @var string $AccountType
     * @access public
     */
    public $AccountType = null;

    public $params = null;

    /**
     * @param string $AccountNumber
     * @param string $Client
     * @param string $MerchantNumber
     * @param string $PartnerCode
     * @param string $ChannelId
     * @param string $AccountType
     * @access public
     */
    public function __construct($AccountNumber, $Client, $MerchantNumber, $PartnerCode, $ChannelId, $AccountType)
    {
        $this->AccountNumber = $AccountNumber;
        $this->Client = $Client;
        $this->MerchantNumber = $MerchantNumber;
        $this->PartnerCode = $PartnerCode;
        $this->ChannelId = $ChannelId;
        $this->AccountType = $AccountType;
        $this->params = [ 
              "AccountNumber" => $AccountNumber
             ,"Client" => $Client
             ,"MerchantNumber" => $MerchantNumber 
             ,"PartnerCode" => $PartnerCode
             ,"ChannelId" => $ChannelId 
             ,"AccountType" => $AccountType 
        ];  

        parent::__construct( $this->params );
  
    }

    public function getOpenReqParmTag(){
        global $appconfig;
        return "<v2:" . get_class($this) . ">";
    }
    public function getClosingReqParmTag(){
        global $appconfig;
        return "</v2:" . get_class($this) . ">";
    }

}
