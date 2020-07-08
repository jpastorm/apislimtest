<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$app = new \Slim\App($config);
define('ROUTE_PREFIX','/apislimtest');
$container=$app->getContainer();

$container['UserController']=function($container){
  return new \App\Controllers\UserController;
};
/*$container['JwtMiddleware']=function(){
  return new \App\Middlewares\JwtMiddleware();
};*/
require '../src/Middlewares/middleware.php';
require '../src/routes/routes.php';

$app->run();
