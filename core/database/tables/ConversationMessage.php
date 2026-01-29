<?php

class ConversationMessage implements CoreTableInterface{
    public static function install(PDO $db){
    //    $db = Connection::connect();
       try {
        // conversation_messages
        $db->exec("
            CREATE TABLE IF NOT EXISTS conversation_messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                conversation_id INT NOT NULL,
                sender_id VARCHAR(150) NOT NULL,
                message TEXT NOT NULL,
                is_read BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                CONSTRAINT fk_conversation FOREIGN KEY (conversation_id) REFERENCES conversations(id),
                CONSTRAINT fk_sender FOREIGN KEY (sender_id) REFERENCES users(user_id)
            ) ENGINE=InnoDB;
        ");
        } catch (\Throwable $th) {
        throw $th;
       }
    }
}
?>