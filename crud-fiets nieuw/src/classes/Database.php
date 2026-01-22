<?php
namespace App;

use PDO;
//include_once "..\config.php";
class Database {
    static function connectDb(){
        $servername = SERVERNAME;
        $username = USERNAME;
        $password = PASSWORD;
        $dbname = DATABASE;
    
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //echo "Connected successfully";
            return $conn;
        } 
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }
}