<?php

/**
 * ErrorAndMessages
 * 
 * Class to handle all error and
 * general Messages
 */

class ErrorAndMessages {
    
    /**
     * Invalid REQUEST type for that Module 
     * 
     * @param String $moduleName contains any Module name or Controller Name
     */
    public static function httpError($moduleName = '') {
        if (!empty($moduleName)) 
            $msg = array('status' => 'Fail', "msg" => "Invalid Http Request");
         else 
            $msg = array('status' => 'Fail', "msg" => "Invalid Http request for $moduleName");
        $msg = array("error" => $msg);
        REST::response($msg, 400);
    }

    /**
     * Invalid Json format
     */

    public static function jsonError() {
        $msg = array('status' => "Fail", "msg" => "Invalid Json format");
        $msg = array("error" => $msg);
        REST::response($msg, 400);
    }

    /**
     * If HTTP HEADER is Invalid
     */

    public static function headerTypeError() {
        $msg = array('status' => "Fail", "msg" => "Invalid header type");
        $msg = array("error" => $msg);
        REST::response($msg, 400);
    }

    /**
     * 
     * @param String $msg contains message to be displayed to user
     * @param Int $statusCode contain status code
     * @param String $nameOfMessage title of the message
     */

    public static function generalMessage($msg, $statusCode, $nameOfMessage = "msg") {
        $msg = array("status" => "Success", $nameOfMessage => $msg);
        $msg = array("Success" => $msg);
        REST::response($msg, $statusCode);
    }

    /**
     * If some parameter is missing when it is required by that Module
     * 
     * @param String $moduleName module name
     */

    public static function parameterError($moduleName = '') {
        if (!empty($moduleName)) 
            $msg = array('status' => 'Fail', "msg" => "Invalid $moduleName parameters");
        else 
            $msg = array('status' => 'Fail', "msg" => "Invalid Parameters");
        $msg = array("error" => $msg);
        REST::response($msg, 400);
    }

    /**
     * Display Error Message to Users
     * 
     * @param type $msg contains Error Message
     * @param type $statusCode contain status Code
     */

    public static function generalError($msg, $statusCode) {
        $msg = array("status" => "Fail", "msg" => $msg);
        $msg = array("error" => $msg);
        REST::response($msg, $statusCode);
    }

}