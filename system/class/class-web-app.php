<?php

/**
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PROJECT_NAME') OR exit();

class webApp {

    /** Safe Input */
    public function strSafeInput($string) {
        if(is_array($string)) {
            foreach($string as $var=>$val) {
                $string[$var] = $this->strSafeInput($val);
            }
        } else {
            $search = array(
                '@<script[^>]*?>.*?</script>@si', // javascript
                '@<[\/\!]*?[^<>]*?>@si', // html tags
                '@<style[^>]*?>.*?</style>@siU', // style tags properly
                '@<![\s\S]*?--[ \t\n\r]*>@', // multi-line comments
                '@<!--(.|\s)*?-->@', // html comments
                '@<!--@', // html comments
            );
            $string = preg_replace($search,'', $string);
        }
        return $string;
    }

    /** Safe Output */
    public function strSafeOutput($string) {
        if(is_array($string)) {
            foreach($string as $var=>$val) {
                $string[$var] = $this->strSafeOutput($val);
            }
        } else {
            $string = htmlentities($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        return $string;
    }

    /** AES Encryption */
    public function strEncrypt($string, $keyValue) {
        try {
            $hash_key = hash('sha256', $keyValue);
            $iv = substr(hash('sha256', $keyValue), 0, 16);
            return base64_encode(openssl_encrypt($string, "AES-256-CBC", $hash_key, 0, $iv));
        } catch(Exception $e) {
            //die($e->getMessage());
            return false;
        }
    }

    /** AES Decryption */
    public function strDecrypt($string, $keyValue) {
        try {
            $hash_key = hash('sha256', $keyValue);
            $iv = substr(hash('sha256', $keyValue), 0, 16);
            return openssl_decrypt(base64_decode($string), "AES-256-CBC", $hash_key, 0, $iv);
        } catch(Exception $e) {
            //die($e->getMessage());
            return false;
        }
    }

    /** Valid Date */
    public function valid_date($myVar,$format = null) {
        if($format == null) { $format = "d-m-Y h:ia"; }
        return date($format, strtotime($myVar));
    }

    /** Check Date */
    public function check_date_exists($myDate) {
        return (bool)strtotime($myDate);
    }

    /** AJAX Passing */
    public function jsEscape($str) {
        return addcslashes( $str, "\\\\'\"&\n\r<>" );
    }

}

$webApp = new webApp();