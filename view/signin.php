<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

<div class="w-full max-w-md bg-white rounded-2xl shadow-lg">

    <!-- Tabs -->
    <div class="flex border-b">
        <button
            id="loginTab"
            onclick="showLogin()"
            class="flex-1 py-3 text-center font-semibold border-b-2 border-blue-600">
            تسجيل دخول
        </button>
        <button
            id="registerTab"
            onclick="showRegister()"
            class="flex-1 py-3 text-center text-gray-500">
            تسجيل جديد
        </button>
    </div>

    <!-- ================= Login ================= -->
    <form action='../chat/apis/check_login.php' id="loginForm" class="p-6 space-y-4" method="post">
            <?php 
if(isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
        <div>
            <label class="block text-sm mb-1">رقم الهاتف</label>
            <input
                type="text"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200"
                placeholder="01xxxxxxxxx"
                name="user_id"
               required
            >

        </div>

        <div>
            <label class="block text-sm mb-1">كلمة المرور</label>
            <input
                type="password"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200"
                name="password"
                required
            >
        </div>

        <button
            class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            دخول
        </button>

    </form>

    <!-- ================= Register ================= -->
    <form action='../chat/apis/add_new_user.php' id="registerForm" class="hidden p-6 space-y-4" method="post">
  <?php 
if(isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
        <div>
            <label class="block text-sm mb-1">الاسم</label>
            <input
                type="text"
                class="w-full px-4 py-2 border rounded-lg"
                placeholder="محمد أحمد"
                name="username"
            >
        </div>

        <div>
            <label class="block text-sm mb-1">رقم الهاتف</label>
            <input
                type="text"
                class="w-full px-4 py-2 border rounded-lg"
                placeholder="01xxxxxxxxx"
                name="user_id"
            >
        </div>

        <div>
            <label class="block text-sm mb-1">البريد الإلكتروني</label>
            <input
                type="email"
                class="w-full px-4 py-2 border rounded-lg"
                name="email"
            >
        </div>

        <div>
            <label class="block text-sm mb-1">كلمة المرور</label>
            <input
                type="password"
                class="w-full px-4 py-2 border rounded-lg"
                name="password"
            >
        </div>

        <button
            class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            إنشاء حساب
        </button>

    </form>

</div>

<script>
function showLogin() {
    loginForm.classList.remove('hidden');
    registerForm.classList.add('hidden');

    loginTab.classList.add('border-blue-600', 'text-black');
    registerTab.classList.remove('border-blue-600', 'text-black');
    registerTab.classList.add('text-gray-500');
}

function showRegister() {
    registerForm.classList.remove('hidden');
    loginForm.classList.add('hidden');

    registerTab.classList.add('border-blue-600', 'text-black');
    loginTab.classList.remove('border-blue-600', 'text-black');
    loginTab.classList.add('text-gray-500');
}
</script>

</body>
</html>
