<?php
#__DIR__ لضمان الوصول للمسار الصحيح مهما كان من يستدعي الملف
require __DIR__ .'/../../vendor/autoload.php';
use Dotenv\Dotenv;
// تحديد مسار الملف
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

interface important
{
    public static function connect();
}

class Connection implements important
{
    // يجب أن تكون الخصائص static ليتم استخدامها داخل دالة static
    private static $conn = null;

    public static function connect()
    {
        // 1. التأكد من عدم وجود اتصال مسبق
        if (self::$conn !== null) {
            return self::$conn;
        }

        try {
            // 2. جلب القيم من البيئة
            $host     = $_ENV['DB_HOST'];
            $dbname   = $_ENV['DB_DATABASE'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];
            $port     = $_ENV['DB_PORT'] ?: '3306';

            // 3. إنشاء الاتصال وتخزينه في كون
            self::$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
            
            // ضبط اعدادات الاتصات
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return self::$conn;

        } catch (PDOException $e) {
            die("فشل الاتصال: " . $e->getMessage());
        }
    }
}

// $conn = Connection::connect();

?>