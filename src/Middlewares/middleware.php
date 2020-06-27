<?php
$mwt = function ($request, $response, $next) {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('content-type: application/json; charset=utf-8');
    $_POST = json_decode(file_get_contents("php://input"), true);
    $response = $next($request, $response);
    return $response;
};
$app->add($mwt);
 ?>
