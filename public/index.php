<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

/*$user = new \App\Models\User;
$user->usuario();
die();*/


$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$app = new \Slim\App($config);

$container=$app->getContainer();

$container['UserController']=function(){
  return new \App\Controllers\UserController;
};
require '../src/Middlewares/middleware.php';
require '../src/routes/routes.php';

$app->run();
