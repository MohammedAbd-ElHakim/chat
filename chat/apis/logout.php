<?php
require __DIR__ .'/../../vendor/autoload.php';
use Dotenv\Dotenv;
// تحديد مسار الملف
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();
if (session_status() === PHP_SESSION_NONE) {
        session_start();
}
session_destroy();
     $baseUrl = $_ENV['APP_URL'];
 header('location:'.$baseUrl.'/view/');
     exit;
         ?>
