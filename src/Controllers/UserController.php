<?php
namespace App\Controllers;

/**
 *
 */
class UserController
{

  public function index($request,$response)
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
}


 ?>
