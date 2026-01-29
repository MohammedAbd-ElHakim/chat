<?php

class Conversation implements CoreTableInterface{
    public static function install(PDO $db){
    //    $db = Connection::connect();
       try {
                // conversations
        $db->exec("
            CREATE TABLE IF NOT EXISTS conversations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_userPhone VARCHAR(15) NOT NULL,
                second_userPhone VARCHAR(15) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                UNIQUE KEY unique_conversation (first_userPhone, second_userPhone),

                CONSTRAINT fk_user_one FOREIGN KEY (first_userPhone) REFERENCES users(user_id),
                CONSTRAINT fk_user_two FOREIGN KEY (second_userPhone) REFERENCES users(user_id)
            ) ENGINE=InnoDB;
        ");

        } catch (\Throwable $th) {
        throw $th;
       }
    }
}
?>