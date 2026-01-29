<?php
require_once '../chat/checkdata/Conversations.php';
require_once '../chat/checkdata/Users.php';
require_once '../core/autoloader.php';
// require_once '../chat/apis/get_conversation_of_user_id.php';
$db = Connection::connect();
?>
<!-- بدايه البحث -->
<div class="p-4 border-b bg-white">
    <div class="relative">
        <input id="searchInput" type="text" 
               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" 
               placeholder="ابحث برقم الهاتف لبدء محادثة...">
        <button onclick="performSearch()" class="absolute left-2 top-2 text-gray-400">
            🔍
        </button>
    </div>
    <div id="searchResult" class="mt-2 hidden">
        </div>
</div>
<!-- نهايه البحث -->
<div id="conversationsList" class="flex-1 overflow-y-auto">
    <div class="p-8 text-center text-gray-400">جاري تحميل المحادثات...</div>
</div>

<script>
async function loadConversations() {
    const listContainer = document.getElementById('conversationsList');
    
    try {
        const response = await fetch('../chat/apis/get_conversation_of_user_id.php');
        const result = await response.json();

        if (result.data && result.data.length > 0) {
            let html = '';
            result.data.forEach(chat => {
                const time = chat.last_message_at ? new Date(chat.last_message_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
                const lastMsg = chat.last_message || 'ابدأ المحادثة الآن...';
                const unreadBadge = chat.unread_count > 0 ? `<span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">${chat.unread_count}</span>` : '';

                html += `
                    <div onclick="openChat(${chat.conversation_id}, '${chat.other_user_name}')" 
                         class="p-4 border-b cursor-pointer hover:bg-gray-100 transition duration-150 flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <div class="font-semibold text-gray-800 truncate">${chat.other_user_name}</div>
                                <span class="text-xs text-gray-400">${time}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <div class="truncate pr-2">${lastMsg}</div>
                                ${unreadBadge}
                            </div>
                        </div>
                    </div>`;
            });
            listContainer.innerHTML = html;
        } else {
            listContainer.innerHTML = '<div class="p-8 text-center text-gray-400">لا توجد محادثات نشطة</div>';
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

// التحديث كل 5 ثوانٍ
loadConversations();
setInterval(loadConversations, 15000);
</script>

<!-- سكريبت الشات -->
 <script>
    async function performSearch() {
    const phone = document.getElementById('searchInput').value;
    const resultDiv = document.getElementById('searchResult');
    
    if (!phone) return;

    try {
        const response = await fetch(`../chat/apis/search_user.php?search_phone=${phone}`);
        const data = await response.json();

        resultDiv.classList.remove('hidden');
        if (data.status === 'success') {
            
            resultDiv.innerHTML = `
                <div class="p-3 bg-blue-50 rounded-lg flex justify-between items-center border border-blue-100">
                    <div>
                        <p class="font-bold text-sm">${data.user.name}</p>
                        <p class="text-xs text-gray-500">${data.user.phone}</p>
                    </div>
                    <button onclick="initiateChat('${data.user.phone}', '${data.user.name}')" 
                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                        مراسلة
                    </button>
                </div>`;
        } else {
            resultDiv.innerHTML = `<p class="text-red-500 text-xs p-2">${data.message}</p>`;
        }
    } catch (e) {
        console.error("Search error:", e);
    }
}

// دالة لبدء المحادثة فعلياً
async function initiateChat(targetId, name) {
    // سنحتاج API بسيط هنا يتأكد هل توجد محادثة قديمة أم ينشئ واحدة جديدة

    const response = await fetch('../chat/apis/get_or_create_conversation.php', {
        method: 'POST',
        body: JSON.stringify({ target_id: String(targetId) }),
        headers: {'Content-Type': 'application/json'}
    });
    const result = await response.json();
    
    if (result.conversation_id) {
        document.getElementById('searchResult').classList.add('hidden');
        document.getElementById('searchInput').value = '';
        loadConversations(); // تحديث القائمة الجانبية
        openChat(result.conversation_id, name); // فتح الشات
    }
}
 </script>