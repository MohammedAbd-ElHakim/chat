<?php
#__DIR__ لضمان الوصول للمسار الصحيح مهما كان من يستدعي الملف
require __DIR__ .'/../../vendor/autoload.php';
use Dotenv\Dotenv;
// تحديد مسار الملف
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();
interface sessionFunctions{
public static function requireLogin(); 
}

#لا يورث ولا يتم تعديله
final class SessionSecurity Implements sessionFunctions
{
    public static function requireLogin()
    {
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!$_SESSION['user_phone']) {
           // جلب الرابط من البيئة لضمان الدقة
           $baseUrl = $_ENV['APP_URL']; 
           header("Location: $baseUrl/view/signin.php");
           exit;
        }
        session_regenerate_id(true);
        return true;
    }

    public static function logout() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION = []; // مسح المصفوفة
    session_destroy(); // تدمير الجلسة
    
    $baseUrl = $_ENV['APP_URL'];
    header("Location: $baseUrl/view/signin.php");
    exit;
}
}
