<?php

/**
 * Rest class responsible for
 * for request and respose
 */

class Rest {

    private static $contentType = "application/json";

    /**
     *  $method store request methods like GET , PUT etc 
     */
    private static $method = "";

    /** 
     * $code store the status code 
     */
    private static $code;

    /** 
     * $data store the POST and PUT Data 
     */
    private static $data = array();

    /**
     * $requestParams store complete data whether data
     * is passed through get request or post/put request
     * $data is merged with $requestParams to make it
     * one complete array
     */
    private static $requestParams;
    
    /**
     * Setting up intial variable
     * like REQUEST Type, REQUEST Method
     */

    public static function init() {
        /* Getting Request Method */
        self::setRequestMethod();
        /* Get if post and put  */
        if (self::getRequestMethod() == 'POST' || self::getRequestMethod() == 'PUT')
            self::inputs();
        /* Check requestParams array */
        self::checkRequestParams();
    }

    /**
     * Creating Response
     * 
     * @param Array $data response data
     * @param Int $status status code
     */
    public static function response($data, $status) {
        $data = self::returnJson($data);
        self::$code = ($status) ? $status : 200;
        self::setHeaders();
        echo $data;
        exit;
    }

    /**
     * Contain Status Code and Message
     * 
     * @return int
     */

    private static function getStatusMessage() {
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($status[self::$code]) ? $status[self::$code] : $status[500];
    }
    
    /**
     * Handle Request and getting data from user in case
     * POST and PUT Request
     * 
     */
    private static function inputs() {
        switch (self::getRequestMethod()) {
            case "POST":
                if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                    $parseData = file_get_contents("php://input");
                    self::$data = json_decode($parseData, TRUE);
                    if (empty(self::$data)) {
                        ErrorAndMessages::jsonError();
                    }
                } else 
                    ErrorAndMessages::headerTypeError();
                break;

            case "GET":
                break;
            case "DELETE":
                break;
            case "PUT";
                if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                    $parseData = file_get_contents("php://input");
                    self::$data = json_decode($parseData, TRUE);
                    if (empty(self::$data)) {
                        ErrorAndMessages::jsonError();
                    }
                } else 
                    ErrorAndMessages::headerTypeError();
                break;
            default:
                ErrorAndMessages::httpError();
                break;
        }
    }

    /**
     * Convert Array into Json format
     * 
     * @param Array $data 
     * @return Json
     */
    protected static function returnJson($data) {
        $json = json_encode($data);
        /* Convert Null Value into 0 in Json String */
        $json = str_replace("null", 0, $json);
        $json = str_replace('\/', '/', $json);
        return $json;
    }

    
    /**
     * Merging Entire request variables into one
     * complete array
     */
    private static function checkRequestParams() {
        /*
         * Appending url keyword to query string
         * i.e twitter.php?retweet={retweet}&count={count}
         */
        $url = 'url=' . $_SERVER['QUERY_STRING'];
        /*
         * queryStringToArray function convert query string into array
         * and assign it to $this->requestParams
         */
        self::$requestParams = queryStringToArray($url);
        /* Merge self::$data and $this->requestParams to get single array */
        self::$requestParams = array_merge(self::$requestParams, self::$data);
        /* checkArray function check for null values and handle sql Injection */
        $flag = checkArray(self::$requestParams);
        if ($flag['status'] == 'fail') {
            ErrorAndMessages::generalError("Invalid value for $flag[key]", 400);
        }
    }

    /**
     * Return complete request variables in an array
     * 
     * @return Array
     */

    public static function getRequestParams() {
        return self::$requestParams;
    }

   
    /**
     * Return Request Method
     * 
     * @return String
     */
    public function getRequestMethod() {
        return self::$method;
    }

    /**
     * Set Request Method
     */
    private static function setRequestMethod() {
        self::$method = $_SERVER['REQUEST_METHOD'];
    }

    
    /**
     * Set Header of Reponse
     */
    private static function setHeaders() {
        header("HTTP/1.1 " . self::$code . " " . self::getStatusMessage());
        header("Content-Type:" . self::$contentType);
    }

}

?>