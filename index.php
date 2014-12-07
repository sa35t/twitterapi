<?php

require_once dirname(__FILE__) . '/utils/helperFunction.php';
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/utils/helperClasses.php';

/**
 * Autoload Class
 * 
 * @param String $className
 */
function autoloader($className) {
    $path = 'libs/';
    require_once $path . $className . '.php';
}
spl_autoload_register('autoloader');
$bootstrap = new Bootstrap();
?>