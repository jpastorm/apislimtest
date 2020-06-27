<?php
namespace App\Middleware;

class JwtMiddleware
{
  public function __invoke($request, $response,$next)
  {
    $response->getBody()->write('class jwt');
    $response = $next($request, $response);
    $response->getBody()->write('class jwt end');

    return $response;
  }
}
 ?>
