<?php
session_start();
require_once '../../core/autoloader.php';
SessionSecurity::requireLogin();

header('Content-Type: application/json');

// استقبال البيانات بتنسيق JSON
$inputData = json_decode(file_get_contents('php://input'), true);

$target_id = $inputData['target_id'] ?? null;
$my_id = $_SESSION['user_phone'] ?? null; // هويتك من الجلسة

if (!$target_id || !$my_id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'بيانات المستخدم غير مكتملة','target_id'=>$target_id,'my_id'=>$my_id
    ]);
    exit;
}

try {
    $db = Connection::connect();
    // تأكد من اسم الكلاس عندك (Conversations أو ConversationsMessages)
    $convRepo = new Conversations($db); 

    // استدعاء الدالة التي كتبتها أنت
    // الدالة ترجع الـ ID سواء كانت المحادثة قديمة أو تم إنشاؤها للتو
    $conversationId = $convRepo->createConversation((string)$my_id, (string)$target_id);

    if ($conversationId) {
        echo json_encode([
            'status' => 'success',
            'conversation_id' => $conversationId
        ]);
    } else {
        throw new Exception("فشل في الحصول على معرف المحادثة");
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error', 
        'my_id' => $my_id, 
        'target_id' => $target_id, 
        'message' => 'خطأ في السيرفر: ' . $e->getMessage()
    ]);
}