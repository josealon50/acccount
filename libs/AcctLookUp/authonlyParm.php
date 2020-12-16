<?php

class authonlyParm
{

    /**
     * @var string $AccountNumber
     * @access public
     */
    public $AccountNumber = null;

    /**
     * @var string $Address1
     * @access public
     */
    public $Address1 = null;

    /**
     * @var string $Address2
     * @access public
     */
    public $Address2 = null;

    /**
     * @var string $Client
     * @access public
     */
    public $Client = null;

    /**
     * @var string $ExpirationMonth
     * @access public
     */
    public $ExpirationMonth = null;

    /**
     * @var string $ExpirationYear
     * @access public
     */
    public $ExpirationYear = null;

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
     * @var string $PromoCode
     * @access public
     */
    public $PromoCode = null;

    /**
     * @var string $PurchaseAmount
     * @access public
     */
    public $PurchaseAmount = null;

    /**
     * @var string $ZipCode
     * @access public
     */
    public $ZipCode = null;

    /**
     * @var string $Cvv2
     * @access public
     */
    public $Cvv2 = null;

    /**
     * @var string $SequenceId
     * @access public
     */
    public $SequenceId = null;

    /**
     * @var string $TrackData
     * @access public
     */
    public $TrackData = null;

    /**
     * @param string $AccountNumber
     * @param string $Address1
     * @param string $Address2
     * @param string $Client
     * @param string $ExpirationMonth
     * @param string $ExpirationYear
     * @param string $MerchantNumber
     * @param string $PartnerCode
     * @param string $PromoCode
     * @param string $PurchaseAmount
     * @param string $ZipCode
     * @param string $Cvv2
     * @param string $SequenceId
     * @param string $TrackData
     * @access public
     */
    public function __construct($AccountNumber, $Address1, $Address2, $Client, $ExpirationMonth, $ExpirationYear, $MerchantNumber, $PartnerCode, $PromoCode, $PurchaseAmount, $ZipCode, $Cvv2, $SequenceId, $TrackData)
    {
      $this->AccountNumber = $AccountNumber;
      $this->Address1 = $Address1;
      $this->Address2 = $Address2;
      $this->Client = $Client;
      $this->ExpirationMonth = $ExpirationMonth;
      $this->ExpirationYear = $ExpirationYear;
      $this->MerchantNumber = $MerchantNumber;
      $this->PartnerCode = $PartnerCode;
      $this->PromoCode = $PromoCode;
      $this->PurchaseAmount = $PurchaseAmount;
      $this->ZipCode = $ZipCode;
      $this->Cvv2 = $Cvv2;
      $this->SequenceId = $SequenceId;
      $this->TrackData = $TrackData;
    }

}
