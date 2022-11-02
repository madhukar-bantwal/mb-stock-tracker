<?php

/**
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../system/auto-load.php');

/** Check Post Data */
foreach($_POST as $key => $value) {
    $_POST[$key] = $webApp->strSafeInput($value);
}

/** Check Command */
if(!isset($_POST['cmd']) || $_POST['cmd'] == "") {
    echo "<script> alert('Invalid Request'); </script>";
	exit();
}

$cmdReq = str_replace('_','-',$_POST['cmd']); // Access File

// Check for Sub-File
if(file_exists(dirname(__FILE__).'/post.'.$cmdReq.'.php')) {
    require_once(dirname(__FILE__).'/post.'.$cmdReq.'.php'); //Success
} else {
    http_response_code(404); //File not found
}