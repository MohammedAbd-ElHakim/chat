<?php
session_start();
require_once '../../core/autoloader.php';
SessionSecurity::requireLogin();

header('Content-Type: application/json');

// استقبال البيانات بتنسيق JSON
$inputData = json_decode(file_get_contents('php://input'), true);

$message = $inputData['message'] ?? null;
$conversationId = $inputData['conversation_id'] ?? null;
$senderId = $_SESSION['user_phone'] ?? null; 

if (!$message || !$conversationId || !$senderId) {
    http_response_code(400);
    echo json_encode(['error' => 'بيانات ناقصة']);
    exit;
}

try {
    $db = Connection::connect();
    $messagesRepo = new ConversationsMessages($db);
    $ConversationMessageData=[
     'conversation_id'=>$conversationId,
     "sender_id"=>$senderId,
     "message"=>$message
    ];
    $isadd = $messagesRepo->addNewMessageToConversation($ConversationMessageData);

         if($isadd){
           echo json_encode(['status' => 'success']);
          }else{
           echo json_encode(['status' => 'حدث خطا اثناء اضافه الرساله الجديده حاول مره اخري لاحقا']);

          }
   
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'خطأ في السيرفر: ' . $e->getMessage()]);
}
?>