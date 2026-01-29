 <?php

interface ConversationsInterface{

#1-السيناريو
#2-اضافه محادثه جديده بين شخصين
#3-جلب محادثه بين شخصين
#4-جلب كل محادثات المستخدم
  // إنشاء محادثة جديدة لو غير موجودة
    public function createConversation(string $userOne, string $userTwo);

    // جلب محادثة موجودة بين مستخدمين
    public function getConversationBetweenUsers(string $userOne, string $userTwo): ?array;

    // جلب كل المحادثات الخاصة بمستخدم
    public function getUserConversations(string $userId): array;
}

class Conversations implements ConversationsInterface {

    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }
    #ترتيب اطراف المحادثه منعا لتكرار انشاء اي محادثه
     private function sortConversion(string $first_userPhone, string $second_UserPhone): array {
        #طبعا اليوزر اي دي عباره عن رقم التلفون للطرفين
        #الphp عموما بتقارن النصوص الرقميه كارقام
        #فهنا التريب حيكون كالتالي 
        #الاصغر ثم الاكبر
        #وحتحفظهم في الداتا بيس مرتبين لضمان عدم حدوث تكرار
        return ($first_userPhone < $second_UserPhone) ? [$first_userPhone, $second_UserPhone] : [$second_UserPhone, $first_userPhone];
    }

    #جلب محادثه بين طرفين
     public function getConversationBetweenUsers(string $firstUser, string $secondUser): ?array {
        [$first, $second] = $this->sortConversion($firstUser, $secondUser);

        #الداتا بيس انجين حيجيب البيانات دي من الفهرس الاتعمل النوعو composite unique index
        $sql = "SELECT * FROM conversations
                WHERE first_userPhone = :first_user
                  AND second_userPhone = :second_user
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':first_user', $first);
        $stmt->bindValue(':second_user', $second);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    #انشاء محادثه جديده
     public function createConversation(string $firstUser, string $secondUser) {
        [$first, $second] = $this->sortConversion($firstUser, $secondUser);

        // لو موجودة رجعها
        $existing = $this->getConversationBetweenUsers($first, $second);
        if ($existing) {
            return true;
        }

        $sql = "INSERT INTO conversations (first_userPhone, second_userPhone )
                VALUES (:first_userPhone, :second_userPhone)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':first_userPhone', $first);
        $stmt->bindValue(':second_userPhone', $second);
        $stmt->execute();

        return true;
    }

    #جلب كل محادثات مستخدم معين
    public function getUserConversations(string $userId): array {
        $sql = "SELECT
    conversation_id,
    user_phone,
    user_name,
    other_user_phone,
    other_user_name,
    last_message,
    last_message_at,
    unread_count
FROM conversation_userData
WHERE user_phone = :user_phone
ORDER BY last_message_at DESC
LIMIT 20;
";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_phone', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    





}
?>