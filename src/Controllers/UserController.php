<?php
namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
/**
 *
 */
class UserController
{

  public function GetUsers(Request $request, Response $response)
  {
    $token=$request->getAttribute('token');
    $jwt= new JwtController();
    $res=$jwt->Check($token);
    if ($res) {
      $user = new \App\Models\User;
      $result=$user->ListUser();
      return $result;
    }
    else{
      return $res;
    }
  }
  public function AddUser(Request $request, Response $response)
  {
    $user = new \App\Models\User;
    $user->username=$request->getParam('username');
    $user->email=$request->getParam('email');
    $user->password=$request->getParam('password');
    $user->avatar=$request->getParam('avatar');
    $result=$user->NewUser();
    return $result;
  }
  public function Login(Request $request,Response $response)
  {
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
      return $token;
    }
    else{
      return json_encode(array("message"=>$message));
    }
  }
  public function Check(Request $request,Response $response)
  {
    $token=$request->getParam('token');
    $jwt= new JwtController();
    $res=$jwt->Check($token);
    var_dump($res);
  }
}


 ?>
