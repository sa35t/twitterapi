<?php

/**
 * Convert array into string
 * array(0=>[a] 1=>[b]) to string 'a','b'
 * 
 * @param Array $status
 * @return String
 */
function convertArrayIntoString($array) {
    foreach ($array as  $value)
        $string .= "'$value,'";
    $string = trim($string, ',');
    return $string;
}

/**
 * Helper Function to change url from "twitter.php?retweet=2&count=20"
 * to
 * Array ([url] => twitter.php
 * [retweet] => 2
 * [count] => 20 )
 * 
 * @param String $string
 * @return Array
 */
function queryStringToArray($string) {
    $url = explode('&', $string);
    /* Request variable to store all parameters */
    $request = array();
    foreach ($url as $value) {
        $new = explode('=', $value);
        $request[$new[0]] = $new[1];
    }
    return $request;
}

/**
 * Check for empty value in an array
 * 
 * @param Array $data 
 * @return JsonString
 */
function checkArray($data) {
    foreach ($data as $key => $value) {
        if ($value == "") {
            $data = array('status' => 'fail', 'key' => $key);
            return $data;
        }
    }
    $data = array('status' => 'success');
    return $data;
}

?>