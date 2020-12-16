<?php

class AccountToBuyResParm
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
     * @var string $City
     * @access public
     */
    public $City = null;

    /**
     * @var string $CreditLimit
     * @access public
     */
    public $CreditLimit = null;

    /**
     * @var string $CurrentBalance
     * @access public
     */
    public $CurrentBalance = null;

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
     * @var string $OpenToBuy
     * @access public
     */
    public $OpenToBuy = null;

    /**
     * @var string $State
     * @access public
     */
    public $State = null;

    /**
     * @var string $ZipCode
     * @access public
     */
    public $ZipCode = null;

    /**
     * @var string $ResponseText
     * @access public
     */
    public $ResponseText = null;

    /**
     * @var string $ResponseCode
     * @access public
     */
    public $ResponseCode = null;

    /**
     * @var string $Token
     * @access public
     */
    public $Token = null;

    /**
     * @var ListOfErrors $ListOfErrors
     * @access public
     */
    public $ListOfErrors = null;

    /**
     * @param string $AccountNumber
     * @param string $Address1
     * @param string $Address2
     * @param string $FirstName
     * @param string $LastName
     * @param string $City
     * @param string $CreditLimit
     * @param string $CurrentBalance
     * @param string $ExpirationMonth
     * @param string $ExpirationYear
     * @param string $OpenToBuy
     * @param string $State
     * @param string $ZipCode
     * @param string $ResponseText
     * @param string $ResponseCode
     * @param string $Token
     * @param ListOfErrors $ListOfErrors
     * @access public
     */
    public function __construct($AccountNumber, $Address1, $Address2, $FirstName, $LastName, $City, $CreditLimit, $CurrentBalance, $ExpirationMonth, $ExpirationYear, $OpenToBuy, $State, $ZipCode, $ResponseText, $ResponseCode, $Token, $ListOfErrors)
    {
      $this->AccountNumber = $AccountNumber;
      $this->Address1 = $Address1;
      $this->Address2 = $Address2;
      $this->FirstName = $FirstName;
      $this->LastName = $LastName;
      $this->City = $City;
      $this->CreditLimit = $CreditLimit;
      $this->CurrentBalance = $CurrentBalance;
      $this->ExpirationMonth = $ExpirationMonth;
      $this->ExpirationYear = $ExpirationYear;
      $this->OpenToBuy = $OpenToBuy;
      $this->State = $State;
      $this->ZipCode = $ZipCode;
      $this->ResponseText = $ResponseText;
      $this->ResponseCode = $ResponseCode;
      $this->Token = $Token;
      $this->ListOfErrors = $ListOfErrors;
    }

}
