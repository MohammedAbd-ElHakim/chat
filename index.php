<?php
require_once('core/autoloader.php');
require_once('bootstrab/install.php');
echo 'تم تهيئه قاعده البيانات بنجاحجاهز للاطلاق الان';

SessionSecurity::requireLogin();

#كده اتأكدنا انو المستخدم مسجل دخوله وتم تهيئه قاعده البيانات
#الانتقال الي الصفحه الرئيسيه
header('location:view/');
exit;
?>