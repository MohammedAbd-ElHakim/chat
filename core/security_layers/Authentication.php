<?php
#حمايه المصادقه

interface authInterface{
    #اول حاجه بنشيك علي اليور نيم والباسوورد
     public function check_phone_and_password($phone, $password);

    #بعد ما نحدد الرول بتاعت اليوزر الحالي او المستخدم الحالي بنفتح ليو جلسه
     public static function startSession($user_phone);
}

class Authentication implements authInterface {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;   
    }

    public function check_phone_and_password($phone, $password) {
        $db = $this->db; 
        
        $sql = "SELECT user_id, password FROM users WHERE user_id = :phone LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        #start session
        self::startSession($user['user_id']);
        return true;
    }

    public static function startSession($user_phone) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['user_phone'] = $user_phone;        
    }     
}


?>