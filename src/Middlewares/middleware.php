<?php
$mwt = function ($request, $response, $next) {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept,Authorization");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-type: application/json; charset=utf-8');

    $_POST = json_decode(file_get_contents("php://input"), true);
    if (!$request->isOptions()) {
      $response = $next($request, $response);
      return $response;
    }else{
      $response->withStatus(200);
      return $response;
    }
};

$Middleware_Authentication = function($request,$response,$next){
  $jwt= new App\Controllers\JwtController();
  //SUPUESTAMENTE VACIO DA 0 Y CUANDO LO LLENAS DA 1 PERO NO SIRVE :V
  //ahora si, aplicaclo en tus otras rutas

  if($request->getQueryParam("token") || $request->getHeader("Authorization")){

    $token = $request->getQueryParam("token");

    if(count($request->getHeader("Authorization")) > 0) {
      $AuthHeader = $request->getHeader("Authorization")[0];
      $token = str_replace('Bearer ', '', $AuthHeader);
    }


    $res = $jwt->Check($token);

    if($res == true) {
      //Pasamos la data del usuario al siguiente middleware
      $request = $request->withAttribute('UserData', $jwt->GetData($token));
      //Pasamos el request al siguiente middleware
      $response = $next($request, $response);
      return $response;
    } else {
      //El token es incorrecto, devolvemos estado 401 (no autorizado)
      return $response->withJson(['error' => 'Token inncorrecto, no autorizado'], 401);
    }


  } else {
    //Devolvermos el error
    return $response->withJson(['error' => 'Token no especificado'], 401);
  }


};
$app->add($mwt);

?>
