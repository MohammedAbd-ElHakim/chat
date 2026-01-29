<?php
require_once('../core/autoloader.php');
SessionSecurity::requireLogin();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gray-100 overflow-hidden">

<div class="flex h-full">

    <!-- ================= Conversations ================= -->
    <aside
        id="conversations"
        class="w-full md:w-1/3 bg-white border-l flex flex-col
               md:block">

        <!-- Header -->
<div class="p-4 border-b font-bold text-lg flex items-center">
    <span>المحادثات</span>

    <form action="../chat/apis/logout.php" method="POST" class="ml-auto">
        <button
            type="submit"
            title="تسجيل الخروج"
            class="p-2 rounded-full hover:bg-gray-100 transition text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
            </svg>
                <span class="hidden md:inline">خروج</span>
        </button>
    </form>
</div>

       
<?php require_once('conversations_of_the_user.php'); ?>
          
    </aside>

    <!-- ================= Chat ================= -->
<?php require_once('chat_box.php'); ?>

</div>

<script>
// function openChat() {
//     document.getElementById('conversations').classList.add('hidden');
//     document.getElementById('chatWindow').classList.remove('hidden');
//     document.getElementById('chatWindow').classList.add('flex');
// }

// function backToList() {
//     document.getElementById('chatWindow').classList.add('hidden');
//     document.getElementById('chatWindow').classList.remove('flex');
//     document.getElementById('conversations').classList.remove('hidden');
// }
</script>

</body>
</html>
