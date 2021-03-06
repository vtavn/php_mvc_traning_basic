<?php
define('_DIR_ROOT', __DIR__);

//xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
    $web_root = 'https://'.$_SERVER['HTTP_HOST'];
}else{
    $web_root = 'http://'.$_SERVER['HTTP_HOST'];
}

$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));

$web_root = $web_root.$folder;

define('_WEB_ROOT', $web_root);

/*
 * tự động load configs
 * */

$configs_dir = scandir('configs');

/*
 * tự động load configs
 * */
$configs_dir = scandir('configs');
if (!empty($configs_dir)){
    foreach ($configs_dir as $item) {
        if ($item != '.' && $item != '..' && file_exists('configs/'.$item)){
            require_once 'configs/'.$item;
        }
    }
}
// load all services
if (!empty($config['app']['service'])){
    $allServices = $config['app']['service'];
    if (!empty($allServices)){
        foreach ($allServices as $serviceName) {
            if (file_exists('app/core/'.$serviceName.'.php')){
                require_once 'app/core/'.$serviceName.'.php';
            }
        }
    }
}
//load service provider
require_once 'core/ServiceProvider.php';
//load view class
require_once 'core/View.php';
require_once 'core/Load.php';
//middleWare
require_once 'core/Middlewares.php';
require_once 'core/Session.php'; // load session class
require_once 'core/Route.php'; // load route class

//kiểm tra config và load database
if (!empty($config['database'])) {
    $db_config = array_filter($config['database']);
    if (!empty($db_config)) {
        require_once 'core/Connection.php';
        require_once 'core/QueryBuilder.php';
        require_once 'core/Database.php';
        require_once 'core/DB.php';
    }
}
//load core helper
require_once 'core/Helper.php';

$allHelper = scandir('app/helpers');
if (!empty($allHelper)){
    foreach ($allHelper as $item) {
        if ($item != '.' && $item != '..' && file_exists('app/helpers/'.$item)){
            require_once 'app/helpers/'.$item;
        }
    }
}

require_once 'app/App.php'; //load app
require_once 'core/Model.php'; //load core model
require_once 'core/Template.php'; //load template
require_once 'core/Controller.php'; //Load base controller
require_once 'core/Request.php'; // load request
require_once 'core/Response.php'; //load response