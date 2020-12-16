<?php

include_once('findOpenToBuyRequest.php');
include_once('AccountToBuyParm.php');
include_once('findOpenToBuyResponse.php');
include_once('AccountToBuyResParm.php');
include_once('enhancedAcctLkpRequest.php');
include_once('EnhancedAcctReqParm.php');
include_once('enhancedAcctLkpResponse.php');
include_once('EnhancedAcctResParm.php');
include_once('ListOfErrors.php');

class AccountLookupService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     * @access private
     */
    private static $classmap = array(
      'findOpenToBuyRequest' => '\findOpenToBuyRequest',
      'AccountToBuyParm' => '\AccountToBuyParm',
      'findOpenToBuyResponse' => '\findOpenToBuyResponse',
      'AccountToBuyResParm' => '\AccountToBuyResParm',
      'enhancedAcctLkpRequest' => '\enhancedAcctLkpRequest',
      'EnhancedAcctReqParm' => '\EnhancedAcctReqParm',
      'enhancedAcctLkpResponse' => '\enhancedAcctLkpResponse',
      'EnhancedAcctResParm' => '\EnhancedAcctResParm',
      'ListOfErrors' => '\ListOfErrors');

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     * @access public
     */
    public function __construct(array $options = array(), $wsdl = './SYF_B2BWS_AcctLkpOTB_Service.wsdl')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      
      parent::__construct($wsdl, $options);
    }

    /**
     * @param enhancedAcctLkpRequest $enhancedAcctLkpRequest
     * @access public
     * @return enhancedAcctLkpResponse
     */
    public function enhancedAcctLkp(enhancedAcctLkpRequest $enhancedAcctLkpRequest)
    {
      return $this->__soapCall('enhancedAcctLkp', array($enhancedAcctLkpRequest));
    }

    /**
     * @param findOpenToBuyRequest $findOpenToBuyRequest
     * @access public
     * @return findOpenToBuyResponse
     */
    public function findOpenToBuy(findOpenToBuyRequest $findOpenToBuyRequest)
    {
      return $this->__soapCall('findOpenToBuy', array($findOpenToBuyRequest));
    }

}
