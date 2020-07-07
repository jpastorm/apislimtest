<?php
namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile;
/**
 *
 */
class UserController {

  public function Prueba(Request $request, Response $response,$args) {
    //return $response->withJson($request->getAttribute('UserData'));
    return $response->write("Hello to " . $args['prueba'] . ", ". $request->getAttribute('UserData')->username);
  }

  public function GetUsers(Request $request, Response $response) {
      $user = new \App\Models\User;
      $result=$user->ListUser();
      return $response->write($result)->withStatus(200);
  }
  public function AddUser(Request $request, Response $response) {

    if (!$request->getParam('username') || !$request->getParam('password') || !$request->getParam('email')) {
    return $response->withJson(['error' => 'Datos incompletos'], 400);
    }
    if (strlen($request->getParam('username')) < 3) {
      return $response->withJson(['error' => 'El campo username es invalido'], 400);
    }
    if (strlen($request->getParam('password')) < 3) {
      return $response->withJson(['error' => 'El campo password es invalido'], 400);
    }
    if (strlen($request->getParam('email')) < 3) {
      return $response->withJson(['error' => 'El campo email es invalido'], 400);
    }

    $user = new \App\Models\User;
    $user->username=$request->getParam('username');
    $user->email=$request->getParam('email');
    $user->password=$request->getParam('password');
    $user->avatar="un avatar";
    $result=$user->NewUser();
    if ($result) {
      return $response->withJson(['message' => 'Se creo correctamente el usuario'], 201);
    }else{
      return $response->withJson(['error' => 'Woops!, Hubo un problema'], 500);
    }

  }
  public function Login(Request $request,Response $response) {
    if (!$request->getParam('username') || !$request->getParam('password')) {
        return $response->withJson(['error' => 'Datos Incompletos'], 400);
      }
    if (strlen($request->getParam('username')) < 3) {
        return $response->withJson(['error' => 'El campo username es invalido'], 400);
      }
    if (strlen($request->getParam('password')) < 3) {
        return $response->withJson(['error' => 'El campo password es invalido'], 400);
      }
      $user= new \App\Models\User;
      $user->username=$request->getParam('username');
      $user->password=$request->getParam('password');
      $result=$user->Checkuser();
      if ($result) {
        $id_user=$obj[0]["id_user"];
        $username=$obj[0]["username"];
        $data=[
          "id_user"=>$id_user,
          "username"=>$username
        ];
        $jwt= new JwtController();
        $token=$jwt->SignIn($data);
        return $response->withJson(['token' => $token], 200);
      }else{
          return $response->withJson(['error' => "No se encontro el usuario en la base de datos"], 401);
       }


  }
  public function Check(Request $request,Response $response) {
    $token=$request->getParam('token');
    $jwt= new JwtController();
    $res=$jwt->Check($token);
    var_dump($res);
  }
  public function Upload(Request $request,Response $response) {
      $username=$request->getAttribute('UserData')->username;
      $id_user=$request->getAttribute('UserData')->id_user;
      $validar=false;
      $nombre=$_FILES['file']['name'];
      $guardado=$_FILES['file']['tmp_name'];

      if($_FILES["file"]["type"] == "image/png"){
        $dirpath= dirname(__DIR__, 2)."/"."avatar"."/".$username;
        if (!file_exists($dirpath)) {
        mkdir($dirpath, 0777,true);
        chmod($dirpath, 0777);
        if (file_exists($dirpath)) {
            if (move_uploaded_file($guardado,$dirpath."/".$nombre)) {
              $validar=true;
            }else{
              $validar=false;
            }
        }
      }else{
        if (move_uploaded_file($guardado,$dirpath."/".$nombre)) {
            $validar=true;
        }else{
            $validar=false;
        }
      }
      if ($validar) {
        $path=$dirpath."/".$nombre;
        $user = new \App\Models\User;
        $user->username=$username;
        $user->id_user=$id_user;
        $user->avatar=$path;
        $result=$user->UpdateAvatar();
        return $response->withJson(['message' => $result], 200);
      }
      else{
        return $response->withJson(['message' => 'No se subio el archivo D:'], 400);
      }
    }else{
      return $response->withJson(['error' => 'Formato incorrecto, Solo se aceptan PNG D:'], 400);
    }



  }
  function Decrypt(Request $request,Response $response)
   {
    if($request->getQueryParam("token")){
      $token = $request->getQueryParam("token");
      $jwt= new JwtController();
      $res=$jwt->GetData($token);//INTRUSO
      return $response->withJson(['data' => $res]);

    }else{
      return $response->withJson(['error' => 'Token inncorrecto, no autorizado'], 401);
    }
  }
  function SearchAvatar(Request $request,Response $response,$args)
  {
    if (isset($args['username'])) {
      $user = new \App\Models\User;
      $user->username=$args['username'];
      $res=$user->FindAvatar();
      if ($res) {
        return $res;
      }
      else{
        return $response->withJson(['error' => 'Woops, tuvimos un error'], 500);
      }
    }else{
      return $response->withJson(['error' => 'No se especifico nada para buscar'], 404);
    }

  }

}

 ?>
