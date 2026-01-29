<?php

interface ConversationsMessagesInterface{

    // إضافة رسالة لمحادثة جديدة أو موجودة
    public function addNewMessageToConversation(array $ConversationMessageData): bool;

    // نفس الإضافة لكن لمحادثة موجودة منطقيًا نفس العملية
    public function updateNewMessageToConversation(array $ConversationMessageData): bool;

    // جلب رسائل محادثة معينة مع pagination
    public function getMassegesOfSpecificConversation(
        int $conversationID,
        int $limit = 20,
        int $offset = 0
    ): array;
}

class ConversationsMessages implements ConversationsMessagesInterface {

    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    /**
     * إضافة رسالة جديدة
     */
    public function addNewMessageToConversation(array $ConversationMessageData): bool
    {
        $sql = "INSERT INTO conversation_messages 
                (conversation_id, sender_id, message) 
                VALUES (:conversation_id, :sender_id, :message)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':conversation_id' => $ConversationMessageData['conversation_id'],
            ':sender_id'       => $ConversationMessageData['sender_id'],
            ':message'         => $ConversationMessageData['message']
        ]);
    }

    /**
     * إضافة رسالة لمحادثة موجودة (نفس INSERT)
     */
    public function updateNewMessageToConversation(array $ConversationMessageData): bool
    {
        // نفس السلوك لأن الرسائل لا تُحدّث بل تُضاف
        return $this->addNewMessageToConversation($ConversationMessageData);
    }

    /**
     * جلب رسائل محادثة معينة
     */
    public function getMassegesOfSpecificConversation(
    int $conversationID,
    int $limit = 20,
    int $LastMessageID = PHP_INT_MAX
): array {

    $sql = "SELECT 
                id,
                sender_id,
                message,
                is_read,
                created_at
            FROM conversation_messages
            WHERE conversation_id = :conversation_id
              AND id < :last_message_id
            ORDER BY id DESC
            LIMIT :limit";

    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(':conversation_id', $conversationID, PDO::PARAM_INT);
    $stmt->bindValue(':last_message_id', $LastMessageID, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
