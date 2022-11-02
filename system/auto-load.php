<?php

/**
 * @author      : Shivananda Shenoy (Madhukar)
 * @version     : 1.0.0
 * @project     : Custom Stock Tracker
 * @created     : 30/10/2022
 * Last Updated : 30/10/2022
 **/

/** Product Configuration */
define('PROJECT_NAME', 'MB Stock Tracker');
define('DEVELOPER', 'Shivananda (Madhukar)');
define('PROJECT_VERSION', '1.0.0');

/** Application Settings */
define('APP_PRODUCTION', false); // TRUE = Production Server, FALSE = UAT Server
define('APP_DEBUG', false); // Debug mode: TRUE - Enabled, FALSE - Disabled
define('CORE_PATH', dirname(__FILE__)); // System path

/** App Config */
if(APP_PRODUCTION == true) {
    ini_set('session.cookie_httponly', 1);
}

/** Debug Config */
if(APP_DEBUG == true) {
    //UAT
    ini_set('display_errors', 'On');
    ini_set('log_errors', 'On');
} else {
    // Production
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
}

/** Encryption Key */
if(!isset($_SESSION['SessionKey']) || $_SESSION['SessionKey'] == NULL) {
    $_SESSION['SessionKey'] = substr(hash('sha256',mt_rand().microtime()),0,12); // New random key
}

/** Custom Headers */
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('X-Powered-By: Shivananda Shenoy (Madhukar)');

/** Start Session **/
session_name('MB-SessID');
session_start();

/** Import Class */
require_once( CORE_PATH . '/custom-class.php');

