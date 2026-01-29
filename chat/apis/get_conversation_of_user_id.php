<?php
require_once '../../core/autoloader.php';
// تأكد أن SessionSecurity يبدأ الجلسة بداخله
SessionSecurity::requireLogin();

header('Content-Type: application/json');

$userPhone = $_SESSION['user_phone'] ?? null;

if (!$userPhone) {
    http_response_code(401); // 401 للوصول غير المصرح
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    $db = Connection::connect();
    $conversationsRepo = new Conversations($db);
    $conversations = $conversationsRepo->getUserConversations($userPhone);

    echo json_encode([
        'data' => $conversations,
        'count' => count($conversations),
        'userPhone' => $userPhone
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}