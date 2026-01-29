<?php

class Users implements CoreTableInterface{
    public static function install(PDO $db){
    //    $db = Connection::connect();
       // users
       try {
        //code...
        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL,
                user_id VARCHAR(150) NOT NULL UNIQUE,
                email VARCHAR(150) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ");
        } catch (\Throwable $th) {
        throw $th;
       }
    }
}
?>