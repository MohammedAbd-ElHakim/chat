<?php
session_start();
require_once '../../core/autoloader.php';
require_once '../checkdata/Users.php';
SessionSecurity::requireLogin();

header('Content-Type: application/json');

$search_phone = $_GET['search_phone'] ?? null;
// نستخدم الـ ID الفعلي للمستخدم للمقارنة الدقيقة
$current_user_id = $_SESSION['user_phone'] ?? null; 

if (!$search_phone) {
    http_response_code(400); // 400 طلب غير مكتمل
    echo json_encode(['status' => 'error', 'message' => 'الرجاء إدخال رقم الهاتف']); 
    exit;
}

try {
    $db = Connection::connect();
    $userRepo = new Users($db);
    $foundUserData=$userRepo->getUserByPhone($search_phone);
   
    if ($foundUserData) {
        // المقارنة بين الـ ID المستخرج من القاعدة والـ ID في الجلسة
        if ((int)$foundUserData['id'] === (int)$current_user_id) {
            echo json_encode(['status' => 'error', 'message' => 'لا يمكنك بدء محادثة مع نفسك!']);
        } else {
            echo json_encode([
                'status' => 'success', 
                'user' => [
                    'id'   => $foundUserData['id'],
                    'name' => $foundUserData['username'],
                    'phone' => $foundUserData['user_id']
                ]
            ]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'المستخدم غير موجود']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'خطأ في السيرفر: ' . $e->getMessage()]);
}