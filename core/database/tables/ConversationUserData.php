<?php

class ConversationUserData implements CoreTableInterface{
    public static function install(PDO $db){
    //    $db = Connection::connect();
       try {
                // ConversationUserData
        $db->exec("
CREATE TABLE IF NOT EXISTS conversation_userData (
    id INT AUTO_INCREMENT PRIMARY KEY,

    conversation_id INT NOT NULL,

    user_phone VARCHAR(15) NOT NULL,
    user_name VARCHAR(100) NOT NULL,

    other_user_phone VARCHAR(15) NOT NULL,
    other_user_name VARCHAR(100) NOT NULL,

    last_message VARCHAR(500) DEFAULT NULL,
    last_message_at DATETIME DEFAULT NULL,

    unread_count INT DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uniq_user_conversation (conversation_id, user_phone),
INDEX idx_sidebar_lookup (user_phone, last_message_at DESC),
    CONSTRAINT fk_conv FOREIGN KEY (conversation_id)
        REFERENCES conversations(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;
        ");

        $db->exec("DROP TRIGGER IF EXISTS after_conversation_insert");
        // إنشاء الـ Trigger بدون DELIMITER (لأنه يتم تنفيذه عبر PDO) 
        $db->exec("
            CREATE TRIGGER after_conversation_insert
            AFTER INSERT ON conversations
            FOR EACH ROW
            BEGIN
                -- إدخال السطر الخاص بالمستخدم الأول
                INSERT INTO conversation_userData (conversation_id, user_phone, user_name, other_user_phone, other_user_name)
                SELECT 
                    NEW.id, u1.user_id, u1.username, u2.user_id, u2.username
                FROM users u1
                JOIN users u2 ON u2.user_id = NEW.second_userPhone
                WHERE u1.user_id = NEW.first_userPhone;

                -- إدخال السطر الخاص بالمستخدم الثاني
                INSERT INTO conversation_userData (conversation_id, user_phone, user_name, other_user_phone, other_user_name)
                SELECT 
                    NEW.id, u2.user_id, u2.username, u1.user_id, u1.username
                FROM users u1
                JOIN users u2 ON u2.user_id = NEW.second_userPhone
                WHERE u1.user_id = NEW.first_userPhone;
            END
        ");

        } catch (\Throwable $th) {
        throw $th;
       }
    }
}
?>