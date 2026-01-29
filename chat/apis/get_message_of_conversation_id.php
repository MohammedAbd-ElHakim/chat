<?php
session_start();
require_once '../../core/autoloader.php';
SessionSecurity::requireLogin();

header('Content-Type: application/json');

// 1. استلام معرف المحادثة من الرابط (GET)
$conversationID = $_GET['conversation_id'] ?? null;

// 2. جلب معرف المستخدم الحالي من الجلسة (للمقارنة في الجافا سكريبت)
$currentUserId = $_SESSION['user_phone'] ?? null; 

if (!$conversationID) {
    http_response_code(400);
    echo json_encode(['error' => 'Conversation ID is required']);
    exit;
}

try {
    $db = Connection::connect();
    $messagesRepo = new ConversationsMessages($db);
    
    // 3. استدعاء الدالة باستخدام الـ ID الرقمي للمحادثة
    $messages = $messagesRepo->getMassegesOfSpecificConversation($conversationID, 20);

    // 4. عكس الترتيب ليكون من الأقدم للأحدث (طبيعي في الشات)
    $messages = array_reverse($messages);

    echo json_encode([
        'status' => 'success',
        'data' => $messages,
        'current_user_id' => $currentUserId // مهم جداً لتمييز رسائلي عن رسائله
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}