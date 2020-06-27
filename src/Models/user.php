<?php
namespace App\Models;
use PDO;
/**
 *
 */
class User
{
  public $id_user;
  public $username;
  public $email;
  public $password;
  public $avatar;

  public function ListUser()
  {
    $db = new \App\Config\db;
    $sql="SELECT * FROM user";
    try{
        $db = $db->connectDB();
        $result = $db->query($sql);
        if ($result->rowCount() > 0) {
            $user=$result->fetchAll(PDO::FETCH_OBJ);
            return json_encode($user);
        }else{
            return json_encode("No existen usuarios en la BD");
        }
        $resultado=null;
        $db=null;
    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }
  }
  public function NewUser()
  {
      $username=$this->username;
      $email=$this->email;
      $password=$this->password;
      $avatar=$this->avatar;
      $db = new \App\Config\db;
      $sql="INSERT INTO user(username,email,password,avatar) VALUES(:username,:email,:password,:avatar)";
      try{

          $db = $db->connectDB();
          $resultado = $db->prepare($sql);
          $resultado->bindParam(':username',$username);
          $resultado->bindParam(':email',$email);
          $resultado->bindParam(':password',$password);
          $resultado->bindParam(':avatar',$avatar);
          $resultado->execute();
          return json_encode("New user saved");
          $resultado=null;
          $db=null;
        }catch(PDOException $e){
          return '{"error":{"text":'.$e->getMessage().'}}';
        }
  }
  public function Checkuser()
  {
    $username=$this->username;
    $password=$this->password;
    $db=new \App\Config\db;
    $sql="SELECT id_user,username FROM user WHERE username=:username and password=:password";
    try{
        $db = $db->connectDB();

        $result = $db->prepare($sql);
        $result->bindParam(':username',$username);
        $result->bindParam(':password',$password);
        $result->execute();
        if ($result->rowCount() > 0) {
            $user=$result->fetchAll(PDO::FETCH_OBJ);
            return json_encode($user);
        }else{
            return json_encode(array("message"=>"No existe el usuario en la BD","estado"=>"false"));
        }
        $result=null;
        $db=null;
    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }
  }
}

?>
