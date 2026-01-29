<?php
session_start();
require_once '../../core/autoloader.php';
require __DIR__ .'/../../vendor/autoload.php';
use Dotenv\Dotenv;
// تحديد مسار الملف
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
#دي الصفحه البتعالج بيانات الفورم وبتشيك لو الباسورد واليوزر اي دي الهو رقم التلفون صح
if(!isset($_POST['user_id']) || !isset($_POST['password'])){
    return 'يجب ادخال الباسورد ورقم الهاتف';
}
  $phone=$_POST['user_id'];
  $password=$_POST['password'];
  
  $db = Connection::connect();
  $auth=new Authentication($db);
  $isfound=$auth->check_phone_and_password($phone,$password);
  if($isfound){
    #الجلسه بتبدا هنا جوه الauth
     $baseUrl = $_ENV['APP_URL'];
     header('location:'.$baseUrl.'/view/');
     exit;
  }else{
        $_SESSION['error'] = 'خطا في كلمه السر او رقم الهاتف';
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit;
    }
}
?>