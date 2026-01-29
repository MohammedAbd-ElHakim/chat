<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conversation_id=$_SESSION['conversation_id'];
$db = Connection::connect();
$all_messages=new ConversationsMessages($db);
$all_messagesArr=$all_messages->getMassegesOfSpecificConversation( $conversation_id);
echo json_encode($all_conversationArr);

?>