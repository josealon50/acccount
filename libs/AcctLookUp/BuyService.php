<?php

include_once('authorizationOnlyRequest.php');
include_once('authorizationOnlyResponse.php');
include_once('authonlyParm.php');
include_once('authonlyResParm.php');
include_once('ListOfErrors.php');

class BuyService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     * @access private
     */
    private static $classmap = array(
      'authorizationOnlyRequest' => '\authorizationOnlyRequest',
      'authorizationOnlyResponse' => '\authorizationOnlyResponse',
      'authonlyParm' => '\authonlyParm',
      'authonlyResParm' => '\authonlyResParm',
      'ListOfErrors' => '\ListOfErrors');

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     * @access public
     */
    public function __construct(array $options = array(), $wsdl = '/Users/josealonsoleon/Downloads/SYF_B2BWS_AuthOnly_Service.wsdl')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      
      parent::__construct($wsdl, $options);
    }

    /**
     * @param authorizationOnlyRequest $authorizationOnlyRequest
     * @access public
     * @return authorizationOnlyResponse
     */
    public function authorizationOnly(authorizationOnlyRequest $authorizationOnlyRequest)
    {
      return $this->__soapCall('authorizationOnly', array($authorizationOnlyRequest));
    }

}
