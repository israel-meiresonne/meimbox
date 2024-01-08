<?php
require_once './model/special/Access/Access.php';
Access::initialize();
require_once 'framework/Configuration.php';
$verboseError = Configuration::get("verboseError");
if ($verboseError) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
require_once 'framework/Router.php';
Router::routerRequest();