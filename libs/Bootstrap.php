<?php

/**
 * Bootstrap
 * 
 * Initial checking and routing request to 
 * correct controller and function of that controller
 * based on REQUEST Type
 */

class Bootstrap {

    public function __construct() {
        Rest::init();
        self::router();
    }
    
    /**
     * Takes care of Routing
     */
    private function router() {
        /* Get all request variables */
        $requestParams = Rest::getRequestParams();
        /* Getting the value of url variable */
        $filename = $requestParams['url'];
        $file = dirname(__FILE__) . '/../Controllers' . '/' . $filename . '.php';
        /* Checking If file exist or not */
        if (file_exists($file)) {
            /* Including the file */
            require_once($file);
            /* Checking If class exist or not */
            if (class_exists($filename)) {
                /* Getting Request Method */
                $request = Rest::getRequestMethod();
                /* Instantiate object of a class */
                $class = new $filename();
                switch ($request) {
                    case 'GET':
                        $class->get($requestParams);
                        break;
                    case 'POST':
                        $class->post($requestParams);
                    case 'PUT':
                        $class->put($requestParams);
                    case 'DELETE':
                        $class->delete($requestParams);
                    default:
                        ErrorAndMessages::httpError('Twitter');
                        break;
                }
            }
            else
            /* Throwing error if Class not found */
                ErrorAndMessages::generalError("Class doesnot Exist", 400);
        }
        else
        /* Throwing error if File not found */
            ErrorAndMessages::generalError("Invalid Url", 400);
    }

}

?>