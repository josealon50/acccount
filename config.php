<?php 
/**
 * This configuration file is used by the Server Side application for Configuration information.
 * One of the first things a server side module will do is to require this file. The client side
 * of the application will use the file config.json to store its configuration information.
 */

$appconfig = array();

// Classpath for php modules developed by Mor Furniture
//---------------------------------------------------------------------------------------------
//-------------------------------------- PHP Classpath ----------------------------------------
//---------------------------------------------------------------------------------------------
$classpath = array("/var/www/public/prod/Synchrony/libs", "/var/www/public/prod/Synchrony/db", "/var/www/public/weblibs/iware");

//---------------------------------------------------------------------------------------------
//------------------------------- Database Configuration --------------------------------------
//---------------------------------------------------------------------------------------------
/*
$appconfig['dbhost'] = '2.4.4.3';
$appconfig['dbname'] = 'dev';
$appconfig['dbuser'] = 'mor';
$appconfig['dbpwd'] = 'dev';
 */

$appconfig['dbhost'] = '2.4.4.2';
$appconfig['dbname'] = 'live';
$appconfig['dbuser'] = 'mor';
$appconfig['dbpwd'] = 'live';

//---------------------------------------------------------------------------------------------
//------------------------------- Synchrony Credentials----------------------------------------
//---------------------------------------------------------------------------------------------
$sync = [];

//username and password
$sync['user'] = "MORFURN44";
$sync['password'] = 'MP1E7aZT';

//Origination Code and Operation Code
$sync['origination_code'] = 'S';
$sync['operation_code'] = 'ST';
$sync['product_code'] = 'QM';

//parameter namespace
$sync['param_namespace'] = [
    'param' => 'java',
    'url' =>  "http://schemas.syf.com/service/apply/java"
];

//body namespace 
$sync['body_namespace'] = [
    "param" => 'v2',
    "url" => "http://schemas.syf.com/services/V2"
];

/*
 * url for webservices for synchrony
 * array that will hold the name 
 * and url for each service
 */

$sync['synchrony_services'] = [
        "acctlookup" => [
            'service' => 'AccountLookUpService',
            'param_namespace' => [ 
                "param" => 'java', 
                "url" => 'http://schemas.syf.com/service/account/java'
            ],
            'service_url' => "http://schemas.syf.com/service/account/java",
            'url' => 'https://www.b2bcreditservices.com/AccountLookupService'
        ],
];

$appconfig['synchrony'] = $sync;


$appconfig['ciphering'] = 'AES-128-CTR';
$appconfig['encryption_key'] = 'TEST-KEY';
$appconfig['encryption_iv'] = '1234567891011121';
$appconfig['options'] = '0';
$appconfig['CALL_DELAY'] = 3;
$appconfig['CREATE_CUST_ASP_ENDPOINT'] = "http://mornet.local/customer/credit";

?>
