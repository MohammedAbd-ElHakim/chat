<?php
// require_once('../core/autoloader.php');

       $db = Connection::connect();

#تثبيت قاعده البياناه والجداول
$installers=[
    new Users,
    new Conversation,
    new ConversationMessage,
    new ConversationUserData
];

foreach ($installers as $installer) {
    $installer::install($db);
}

?>