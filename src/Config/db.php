<?php
namespace App\Config;
use PDO;
class db{
    private $dbHost='localhost';
    private $dbUser='admin';
    private $dbPass='Sistemas.2020';
    private $dbName='apislim';

    //connection

    public function connectDB(){
        $mysqlConnect="mysql:host=$this->dbHost;dbname=$this->dbName";
        $dbConnection=new PDO($mysqlConnect,$this->dbUser,$this->dbPass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }

}
?>
