<?php


interface UsersInterface{
    // إضافة مستخدم جديد
    public function createNewUser(array $userData): bool;

    // جلب user_id عن طريق الإيميل
    public function getUserIdByEmail(string $email): ?string;
    public function getNameByuserID(string $user_id): ?string;
    public function getUserByPhone($phone);
}

class Users implements UsersInterface {

    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    /**
     * إنشاء مستخدم جديد
     */
    public function createNewUser(array $userData): bool
    {
        $sql = "INSERT INTO users (username, user_id, email, password)
                VALUES (:username, :user_id, :email, :password)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $userData['username'],
            ':user_id'  => $userData['user_id'], // phone
            ':email'    => $userData['email'],
            ':password' => password_hash($userData['password'], PASSWORD_BCRYPT)
        ]);
    }

    /**
     * جلب user_id باستخدام الإيميل
     */
    public function getUserIdByEmail($email): ?string
    {
        $sql = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['user_id'] : false;
    }
    
    public function getNameByuserID(string $user_id): ?string
    {
        $sql = "SELECT username FROM users WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['username'] : 'مستخدم غير معرف ';
    }

    public function getUserByPhone($phone) {
    $sql = "SELECT id, username ,user_id  FROM users WHERE user_id = :user_id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':user_id', $phone);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
