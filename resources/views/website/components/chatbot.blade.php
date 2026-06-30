@php
    // Ambil data FAQ dari database
    $faqs = \App\Models\Faq::select('id', 'question', 'answer')->get();
@endphp

<style>
    /* Styling Dasar Chatbot */
    #kopace-widget {
        position: fixed;
        bottom: 90px;
        left: 20px;
        z-index: 9999;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    #kopace-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        text-align: center;
        line-height: 60px;
        font-size: 28px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }

    #kopace-btn:hover {
        transform: scale(1.1);
    }

    #kopace-window {
        display: none;
        position: absolute;
        bottom: 80px;
        right: 0; 
        left: auto;
        width: 350px;
        height: 500px;
        background-color: #f8f9fa;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        overflow: hidden;
        flex-direction: column;
        border: 1px solid #dee2e6;
    }

    /* Header */
    #kopace-header {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: white;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #kopace-header .header-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #kopace-header .avatar {
        width: 40px;
        height: 40px;
        background-color: white;
        color: #0d6efd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
    }

    #kopace-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    #kopace-header small {
        font-size: 12px;
        opacity: 0.8;
    }

    #kopace-close {
        cursor: pointer;
        font-size: 20px;
        opacity: 0.8;
    }
    #kopace-close:hover { opacity: 1; }

    /* Body/Area Pesan */
    #kopace-body {
        flex-grow: 1;
        padding: 15px;
        overflow-y: auto;
        background-color: #f0f2f5;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Balon Pesan */
    .msg-bubble {
        max-width: 85%;
        padding: 10px 15px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.4;
        animation: fadeIn 0.3s ease-in-out;
    }

    .msg-bot {
        background-color: white;
        color: #333;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .msg-user {
        background-color: #0d6efd;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* Pilihan Topik (FAQ) */
    .faq-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 5px;
        align-self: flex-start;
        width: 100%;
    }

    .faq-btn {
        background-color: white;
        border: 1px solid #0d6efd;
        color: #0d6efd;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 13px;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s;
    }

    .faq-btn:hover {
        background-color: #0d6efd;
        color: white;
    }

    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        gap: 5px;
        padding: 5px 10px;
    }
    .typing-indicator span {
        width: 6px;
        height: 6px;
        background-color: #999;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }
    .typing-indicator span:nth-child(1) { animation-delay: 0s; }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typing {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Input Area / Footer */
    #kopace-input-area {
        padding: 10px;
        background-color: white;
        border-top: 1px solid #dee2e6;
        display: flex;
        gap: 8px;
    }

    #kopace-search {
        flex-grow: 1;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s;
    }
    #kopace-search:focus {
        border-color: #0d6efd;
    }

    #kopace-restart-btn {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #0d6efd;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
        flex-shrink: 0;
    }
    #kopace-restart-btn:hover {
        background-color: #e9ecef;
    }
</style>

<div id="kopace-widget">
    <!-- Tombol Mengambang -->
    <div id="kopace-btn" onclick="toggleKopace()">
        <i class="bi bi-chat-dots-fill"></i>
    </div>

    <!-- Jendela Chat -->
    <div id="kopace-window">
        <!-- Header -->
        <div id="kopace-header">
            <div class="header-info">
                <div class="avatar"><i class="bi bi-robot"></i></div>
                <div>
                    <h5>Kopace BKN</h5>
                    <small>Asisten Virtual BKN Reg XIV</small>
                </div>
            </div>
            <div id="kopace-close" onclick="toggleKopace()"><i class="bi bi-x-lg"></i></div>
        </div>

        <!-- Body -->
        <div id="kopace-body">
            <!-- Isi chat akan dimuat via JS -->
        </div>

        <!-- Footer / Input Area -->
        <div id="kopace-input-area">
            <button id="kopace-restart-btn" onclick="restartKopace()" title="Kembali ke awal">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
            <input type="text" id="kopace-search" placeholder="Ketik topik bantuan..." oninput="filterFaqs(this.value)" autocomplete="off">
        </div>
    </div>
</div>

<script>
    // Data FAQ dari Database Laravel
    const faqs = @json($faqs);
    let kopaceIsOpen = false;
    let isInitialized = false;

    function toggleKopace() {
        const win = document.getElementById('kopace-window');
        kopaceIsOpen = !kopaceIsOpen;
        win.style.display = kopaceIsOpen ? 'flex' : 'none';
        
        if (kopaceIsOpen && !isInitialized) {
            initKopace();
            isInitialized = true;
        }
    }

    function initKopace() {
        const body = document.getElementById('kopace-body');
        body.innerHTML = ''; // Bersihkan layar
        
        // Sapaan awal
        appendBotMessage("Halo! 👋 Saya Kopace, Asisten Virtual Kantor Regional XIV BKN. Silakan pilih topik yang ingin Anda tanyakan di bawah ini:");
        
        // Tampilkan daftar pertanyaan
        if (faqs.length > 0) {
            showFaqOptions();
        } else {
            appendBotMessage("Mohon maaf, saat ini belum ada informasi bantuan yang tersedia.");
        }
    }

    function showFaqOptions() {
        const body = document.getElementById('kopace-body');
        
        const optionsDiv = document.createElement('div');
        optionsDiv.className = 'faq-options';
        
        faqs.forEach((faq, index) => {
            const btn = document.createElement('button');
            btn.className = 'faq-btn';
            btn.innerText = faq.question;
            btn.onclick = () => handleQuestionClick(faq);
            optionsDiv.appendChild(btn);
        });
        
        body.appendChild(optionsDiv);
        scrollToBottom();
    }

    function handleQuestionClick(faq) {
        // Hapus daftar pertanyaan dari layar agar rapi
        const optionsDivs = document.querySelectorAll('.faq-options');
        optionsDivs.forEach(div => div.style.display = 'none');

        // Bersihkan kotak pencarian
        const searchInput = document.getElementById('kopace-search');
        if (searchInput) searchInput.value = '';

        // Tampilkan pesan pengguna
        appendUserMessage(faq.question);

        // Tampilkan indikator mengetik
        const typingId = showTypingIndicator();

        // Jeda simulasi bot mengetik (1.5 detik)
        setTimeout(() => {
            removeElement(typingId);
            appendBotMessage(faq.answer);
            
            // Tawarkan untuk bertanya lagi setelah jawaban diberikan
            setTimeout(() => {
                appendBotMessage("Ada hal lain yang bisa Kopace bantu?");
                showFaqOptions();
            }, 1000);
            
        }, 1500);
    }

    function appendBotMessage(text) {
        const body = document.getElementById('kopace-body');
        const msgDiv = document.createElement('div');
        msgDiv.className = 'msg-bubble msg-bot';
        msgDiv.innerHTML = text; // Gunakan innerHTML agar tag HTML di answer (bila ada) dirender
        body.appendChild(msgDiv);
        scrollToBottom();
    }

    function appendUserMessage(text) {
        const body = document.getElementById('kopace-body');
        const msgDiv = document.createElement('div');
        msgDiv.className = 'msg-bubble msg-user';
        msgDiv.innerText = text;
        body.appendChild(msgDiv);
        scrollToBottom();
    }

    function showTypingIndicator() {
        const body = document.getElementById('kopace-body');
        const typingId = 'typing-' + Date.now();
        
        const msgDiv = document.createElement('div');
        msgDiv.id = typingId;
        msgDiv.className = 'msg-bubble msg-bot';
        msgDiv.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
        
        body.appendChild(msgDiv);
        scrollToBottom();
        return typingId;
    }

    function removeElement(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    function scrollToBottom() {
        const body = document.getElementById('kopace-body');
        body.scrollTop = body.scrollHeight;
    }

    function restartKopace() {
        // Bersihkan kotak pencarian
        const searchInput = document.getElementById('kopace-search');
        if (searchInput) searchInput.value = '';
        
        initKopace();
    }

    function filterFaqs(keyword) {
        const keywordLower = keyword.toLowerCase();
        
        // Ambil elemen div opsi terakhir
        const optionsDivs = document.querySelectorAll('.faq-options');
        if (optionsDivs.length === 0) return;
        const lastOptionsDiv = optionsDivs[optionsDivs.length - 1];
        
        // Jika opsi sedang disembunyikan (artinya pengguna sudah mengobrol), panggil ulang opsi
        if (lastOptionsDiv.style.display === 'none' && keyword.trim() !== '') {
            appendBotMessage("Mencari topik lain? Silakan pilih hasil di bawah:");
            showFaqOptions();
            return; // oninput berikutnya yang akan menyaring
        }

        const buttons = lastOptionsDiv.querySelectorAll('.faq-btn');
        let hasVisible = false;

        buttons.forEach(btn => {
            const text = btn.innerText.toLowerCase();
            if (text.includes(keywordLower)) {
                btn.style.display = 'block';
                hasVisible = true;
            } else {
                btn.style.display = 'none';
            }
        });

        // Tampilkan pesan peringatan jika tidak ada hasil
        let noResultMsg = lastOptionsDiv.querySelector('.no-result-msg');
        if (!hasVisible) {
            if (!noResultMsg) {
                noResultMsg = document.createElement('div');
                noResultMsg.className = 'no-result-msg';
                noResultMsg.style.fontSize = '12px';
                noResultMsg.style.color = '#dc3545';
                noResultMsg.style.padding = '5px 10px';
                noResultMsg.style.fontStyle = 'italic';
                noResultMsg.innerText = 'Topik tidak ditemukan.';
                lastOptionsDiv.appendChild(noResultMsg);
            }
        } else {
            if (noResultMsg) noResultMsg.remove();
        }
    }
</script>
