<?php

class authonlyResParm
{

    /**
     * @var string $AuthorizationCode
     * @access public
     */
    public $AuthorizationCode = null;

    /**
     * @var string $AvsCode
     * @access public
     */
    public $AvsCode = null;

    /**
     * @var string $OFPLanguage
     * @access public
     */
    public $OFPLanguage = null;

    /**
     * @var string $ResponseText
     * @access public
     */
    public $ResponseText = null;

    /**
     * @var string $Status
     * @access public
     */
    public $Status = null;

    /**
     * @var string $TransactionId
     * @access public
     */
    public $TransactionId = null;

    /**
     * @var string $ResponseCode
     * @access public
     */
    public $ResponseCode = null;

    /**
     * @var string $Cvv2Result
     * @access public
     */
    public $Cvv2Result = null;

    /**
     * @var ListOfErrors $ListOfErrors
     * @access public
     */
    public $ListOfErrors = null;

    /**
     * @param string $AuthorizationCode
     * @param string $AvsCode
     * @param string $OFPLanguage
     * @param string $ResponseText
     * @param string $Status
     * @param string $TransactionId
     * @param string $ResponseCode
     * @param string $Cvv2Result
     * @param ListOfErrors $ListOfErrors
     * @access public
     */
    public function __construct($AuthorizationCode, $AvsCode, $OFPLanguage, $ResponseText, $Status, $TransactionId, $ResponseCode, $Cvv2Result, $ListOfErrors)
    {
      $this->AuthorizationCode = $AuthorizationCode;
      $this->AvsCode = $AvsCode;
      $this->OFPLanguage = $OFPLanguage;
      $this->ResponseText = $ResponseText;
      $this->Status = $Status;
      $this->TransactionId = $TransactionId;
      $this->ResponseCode = $ResponseCode;
      $this->Cvv2Result = $Cvv2Result;
      $this->ListOfErrors = $ListOfErrors;
    }

}
