<?php

# 判断PHP版本

# 初始化时区
define('APP_ROOT',dirname(__DIR__));
define('SITE_URL','http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,-10));
date_default_timezone_set('Asia/Shanghai');
#加载路由

require  '../../vendor/autoload.php';
//$config = require '../config/base.php';

$router = new AltoRouter();

// map homepage
$router->map( 'GET', '/', function() {

});

// map user details page
$router->map( 'GET', '/user/[i:id]', function( $id ) {
    echo $id;
});

//$router->map( 'GET', '/todo/index', function() {
//    $todo = new \app\controllers\TodoController();
//    $todo->index();
//});

$router->map( 'GET|POST', '/[a:controller]/[a:action]', function($controller,$action) {
    $controllerClass = '\app\controllers\\'.ucfirst($controller).'Controller';
    $controller = new $controllerClass;
    if(method_exists($controller,$action)) {
        $controller->$action();
    }else{
        die($action.' is not found');
    }
});

$router->map('GET|POST', '/[a:controller]/[a:action]/[**:]', function ($controller, $action) {
    $args = explode('/', $_SERVER['REQUEST_URI']);
    $args = array_slice($args, 3);
//    parse_str($args[0],$args);
    $controllerClass = '\app\controllers\\'.ucfirst($controller).'Controller';
    $controller = new $controllerClass;
    if (method_exists($controller, $action)) {
        $controller->$action(...$args);
    } else {
        exit('route is not exits');
    }
});


// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
    // no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}