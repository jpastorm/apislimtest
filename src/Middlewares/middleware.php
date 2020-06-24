<?php
$mwjwt = function ($request, $response, $next) {
    $response->getBody()->write('BEFORE');
    $response = $next($request, $response);
    $response->getBody()->write('AFTER');

    return $response;
};
$mwt = function ($request, $response, $next) {
    $response->getBody()->write('antes');
    $response = $next($request, $response);
    $response->getBody()->write('despues');

    return $response;
};
$app->add($mwjwt);
 ?>
