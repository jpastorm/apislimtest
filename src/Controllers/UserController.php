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
      return $result;
  }
  public function AddUser(Request $request, Response $response) {
    $user = new \App\Models\User;
    $user->username=$request->getParam('username');
    $user->email=$request->getParam('email');
    $user->password=$request->getParam('password');
    $user->avatar="un avatar";
    $result=$user->NewUser();
    return json_decode(array("message"=>$result));
  }
  public function Login(Request $request,Response $response) {
    $user= new \App\Models\User;
    $user->username=$request->getParam('username');
    $user->password=$request->getParam('password');
    $result=$user->Checkuser();
    $obj=json_decode($result,true);
    $res=$obj["estado"];
    $message=$obj["message"];
    if ($res!="false") {
      $id_user=$obj[0]["id_user"];
      $username=$obj[0]["username"];
      $data=[
        "id_user"=>$id_user,
        "username"=>$username
      ];
      $jwt= new JwtController();
      $token=$jwt->SignIn($data);
      return json_encode(array("token"=>$token));
    }
    else{
      return json_encode(array("message"=>$message));
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
      return json_encode(array("message"=>$result));
    }
    else{
      return json_encode(array("message"=>"ocurrio un error"));

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
  function SearchAvatar(Request $request,Response $response)
  {
    $id_user=$request->getAttribute('UserData')->id_user;
    $user = new \App\Models\User;
    $user->id_user=$id_user;
    $result=$user->FindAvatar();
    return $response->withJson(['data' => $result]);
  }

}

 ?>
