<?php
session_start();
require_once '../../core/autoloader.php';
require_once '../checkdata/Users.php';
require __DIR__ .'/../../vendor/autoload.php';
use Dotenv\Dotenv;
// تحديد مسار الملف
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
#دي الصفحه البتعالج بيانات الفورم وبتشيك لو الباسورد واليوزر اي دي الهو رقم التلفون صح
if(!isset($_POST['username']) || !isset($_POST['user_id']) || !isset($_POST['email']) || !isset($_POST['password'])){
        $_SESSION['error'] = 'كل البيانات مطلوبه';
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit;}
  $username=$_POST['username'];
  $user_id=$_POST['user_id'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  
  $db = Connection::connect();
  $newuser=new Users($db);
  $userdataArr=[
    'username'=>$username,
    'user_id'=>$user_id,
    'email'=>$email,
    'password'=>$password
  ];
  $isadd=$newuser->createNewUser($userdataArr);
  if($isadd){
     #بدا جلسه وتسجيل الدخول
     $auth=new Authentication($db);
     $auth->startSession($user_id);
     $baseUrl = $_ENV['APP_URL'];
     header('location:'.$baseUrl.'/view/');
     exit;
  }else{
        $_SESSION['error'] = 'حدث خطا اثناء اضافه المستخدم الجديد';
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit;
    }
}
?>