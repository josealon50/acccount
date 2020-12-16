<?php

class EnhancedAcctReqParm extends SynchronyBody
{

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
     * @var string $Ssn
     * @access public
     */
    public $Ssn = null;

    /**
     * @var string $ZipCode
     * @access public
     */
    public $ZipCode = null;

    /**
     * @var string $ChannelId
     * @access public
     */
    public $ChannelId = null;

    /**
     * @var string $ProductCode
     * @access public
     */
    public $ProductCode = null;

    /**
     * @var string $CHDPrefix1
     * @access public
     */
    public $CHDPrefix1 = null;

    /**
     * @var string $CHDPrefix2
     * @access public
     */
    public $CHDPrefix2 = null;

    /**
     * @var string $CHDPrefix3
     * @access public
     */
    public $CHDPrefix3 = null;

    /**
     * @var string $CHDPrefix4
     * @access public
     */
    public $CHDPrefix4 = null;

    /**
     * @var string $FirstName
     * @access public
     */
    public $FirstName = null;

    /**
     * @var string $LastName
     * @access public
     */
    public $LastName = null;

    /**
     * @var string $AccountType
     * @access public
     */
    public $AccountType = null;

    /**
     * @var string $PhoneNumber
     * @access public
     */
    public $PhoneNumber = null;

    public $params = null;

    /**
     * @param string $Client
     * @param string $MerchantNumber
     * @param string $PartnerCode
     * @param string $Ssn
     * @param string $ZipCode
     * @param string $ChannelId
     * @param string $ProductCode
     * @param string $CHDPrefix1
     * @param string $CHDPrefix2
     * @param string $CHDPrefix3
     * @param string $CHDPrefix4
     * @param string $FirstName
     * @param string $LastName
     * @param string $AccountType
     * @param string $PhoneNumber
     * @access public
     */
    public function __construct($Client, $MerchantNumber, $PartnerCode, $Ssn, $ZipCode, $ChannelId, $ProductCode, $CHDPrefix1, $CHDPrefix2, $CHDPrefix3, $CHDPrefix4, $FirstName, $LastName, $AccountType, $PhoneNumber)
    {
      $this->Client = $Client;
      $this->MerchantNumber = $MerchantNumber;
      $this->PartnerCode = $PartnerCode;
      $this->Ssn = $Ssn;
      $this->ZipCode = $ZipCode;
      $this->ChannelId = $ChannelId;
      $this->ProductCode = $ProductCode;
      $this->CHDPrefix1 = $CHDPrefix1;
      $this->CHDPrefix2 = $CHDPrefix2;
      $this->CHDPrefix3 = $CHDPrefix3;
      $this->CHDPrefix4 = $CHDPrefix4;
      $this->FirstName = $FirstName;
      $this->LastName = $LastName;
      $this->AccountType = $AccountType;
      $this->PhoneNumber = $PhoneNumber;

      $this->params =  [
                              'Client' => $Client, 
                              'MerchantNumber' => $MerchantNumber, 
                              'PartnerCode' => $PartnerCode, 
                              'Ssn' => $Ssn, 
                              'ZipCode' => $ZipCode, 
                              'ChannelId' => $ChannelId, 
                              'ProductCode' => $ProductCode, 
                              'CHDPrefix1' => $CHDPrefix1, 
                              'CHDPrefix2' => $CHDPrefix2, 
                              'CHDPrefix3' => $CHDPrefix3, 
                              'CHDPrefix4' => $CHDPrefix4, 
                              'FirstName' => $FirstName, 
                              'LastName' => $LastName, 
                              'AccountType' => $AccountType, 
                              "PhoneNumber" => $PhoneNumber 
                        ];

      parent::__construct( $this->params );
    }

    public function getOpenReqParmTag(){
        return "<v2:" . get_class($this) . ">";
    }
    public function getClosingReqParmTag(){
        return "</v2:" . get_class($this) . ">";
    }

}
