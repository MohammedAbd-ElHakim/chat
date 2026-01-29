 <!-- ================= Chat ================= -->
    <main id="chatWindow" class="hidden md:flex flex-1 flex-col bg-gray-50">
    <div class="p-4 bg-white border-b flex items-center gap-3">
        <button onclick="backToList()" class="md:hidden text-blue-600">← رجوع</button>
        <div id="chatHeaderName" class="font-semibold text-lg text-gray-800">إختر محادثة</div>
    </div>

    <div id="messagesList" class="flex-1 overflow-y-auto p-4 space-y-3 bg-[#eee]">
        لم تبدا محادثه بعد
        </div>

    <form id="messageForm" class="p-4 bg-white border-t flex gap-2">
        <input type="hidden" id="activeConversationId">
        <input id="messageInput" class="flex-1 px-4 py-2 border rounded-full focus:outline-none" placeholder="اكتب رسالة...">
        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-full">إرسال</button>
    </form>
</main>

<script>
   // تعريف المتغير في الأعلى ليكون متاحاً لجميع الدوال
let messagesInterval = null;

async function openChat(conversationId, otherUserName) {
    const chatMain = document.getElementById('chatWindow'); 
    const headerName = document.getElementById('chatHeaderName');
    const messageForm = document.getElementById('messageForm');

    // التحقق من وجود العناصر قبل البدء لمنع الأخطاء
    if (!chatMain) {
        console.error("Error: chatWindow element not found!");
        return;
    }

    chatMain.classList.remove('hidden');
    chatMain.classList.add('md:flex'); 
    if(headerName) headerName.innerText = otherUserName; 

    // تخزين الـ ID في الـ Dataset الخاص بالفورم
    if(messageForm) messageForm.dataset.currentId = conversationId;

    await fetchMessages(conversationId);

    if (messagesInterval) clearInterval(messagesInterval);
    messagesInterval = setInterval(() => fetchMessages(conversationId), 5000);
}

async function fetchMessages(conversationId) {
    const messagesContainer = document.getElementById('messagesList');
    if (!messagesContainer) return;

    try {
        // تم تصحيح الرابط وإزالة المتغيرات الزائدة
        const response = await fetch(`../chat/apis/get_message_of_conversation_id.php?conversation_id=${conversationId}`);
        const result = await response.json();
        
        if (result.data) {
            let messagesHtml = '';
            result.data.forEach(msg => {
                // تأكد أن msg.sender_id يطابق نوع البيانات في قاعدة البيانات (String أو Int)
                const isMe = String(msg.sender_id) === String(result.current_user_id); 
                
                messagesHtml += `
                    <div class="flex ${isMe ? 'justify-end' : 'justify-start'}">
                        <div class="${isMe ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 shadow-sm'} p-3 rounded-2xl max-w-xs">
                            <p class="text-sm">${msg.message}</p>
                            <div class="text-[10px] mt-1 opacity-70 text-right">
                                ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </div>
                        </div>
                    </div>`;
            });
            
            if (messagesContainer.innerHTML !== messagesHtml) {
                messagesContainer.innerHTML = messagesHtml;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }
    } catch (error) { console.error("Fetch Messages Error:", error); }
}
</script>

<!-- سكريبت ارسال رساله جديده -->
 <script>
    document.getElementById('messageForm').addEventListener('submit', async function(e) {
    e.preventDefault(); // منع الصفحة من إعادة التحميل

    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    const conversationId = this.dataset.currentId; // جلب الـ ID الذي حفظناه عند فتح الشات
console.log('convid : ' + conversationId);
console.log('message : ' + message);
    if (!message || !conversationId) return;

    // تعطيل الزر مؤقتاً لمنع الإرسال المتكرر
    const submitBtn = this.querySelector('button');
    submitBtn.disabled = true;

    try {
        const response = await fetch('../chat/apis/send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                conversation_id: conversationId,
                message: message
            })
        });

        const result = await response.json();

        if (result.status === 'success') {
            input.value = ''; // مسح خانة الكتابة
            await fetchMessages(conversationId); // تحديث الشات فوراً لرؤية رسالتك
        } else {
            alert('فشل إرسال الرسالة: ' + result.error);
        }
    } catch (error) {
        console.error('Error sending message:', error);
    } finally {
        submitBtn.disabled = false; // إعادة تفعيل الزر
    }
});
 </script>