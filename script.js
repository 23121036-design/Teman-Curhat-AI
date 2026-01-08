document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const messagesContainer = document.getElementById('messages-container');
    const typingIndicator = document.getElementById('typing-indicator');
    const resetChatBtn = document.getElementById('reset-chat-btn');
    
    // Navigation Elements
    const menuItems = document.querySelectorAll('.menu-item[data-target]');
    const sections = document.querySelectorAll('.content-section');

    // Jurnal Elements
    const jurnalText = document.getElementById('jurnal-text');
    const saveJurnalBtn = document.getElementById('save-jurnal-btn');
    const jurnalList = document.getElementById('jurnal-list');

    // Settings Elements
    const usernameInput = document.getElementById('username-input');
    const saveSettingsBtn = document.getElementById('save-settings-btn');

    // State
    let username = localStorage.getItem('tc_username') || 'Teman';

    // Initialization
    init();

    function init() {
        chatInput.focus();
        loadJurnal();
        loadSettings();
        
        // Navigation Event Listeners
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                const targetId = item.getAttribute('data-target');
                navigateTo(targetId);
            });
        });

        // Chat Event Listeners
        sendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
        resetChatBtn.addEventListener('click', resetChat);

        // Jurnal Event Listeners
        saveJurnalBtn.addEventListener('click', saveJurnalEntry);

        // Settings Event Listeners
        saveSettingsBtn.addEventListener('click', saveSettings);
    }

    // --- NAVIGATION ---
    function navigateTo(targetId) {
        // Update active menu item
        menuItems.forEach(item => {
            if (item.getAttribute('data-target') === targetId) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Show target section, hide others
        sections.forEach(section => {
            if (section.id === targetId) {
                section.classList.remove('hidden');
                section.classList.add('active');
            } else {
                section.classList.add('hidden');
                section.classList.remove('active');
            }
        });
    }

    // --- CHAT LOGIC ---
    function sendMessage() {
        const messageText = chatInput.value.trim();
        if (messageText === "") return;

        // 1. Append User Message
        appendMessage(messageText, 'user');
        chatInput.value = '';
        
        // 2. Show Typing Indicator
        showTyping(true);

        // 3. Send to Backend (API)
        fetch('api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                message: messageText,
                username: username // Send username for personalized response if API supports it
            })
        })
        .then(response => response.json())
        .then(data => {
            showTyping(false);
            if (data.success) {
                appendMessage(data.reply, 'ai');
            } else {
                appendMessage("Maaf, aku lagi pusing sedikit (Error: " + data.error + ")", 'ai');
            }
        })
        .catch(error => {
            showTyping(false);
            appendMessage("Waduh, koneksiku terputus. Coba lagi ya?", 'ai');
            console.error('Error:', error);
        });
    }

    function appendMessage(text, sender) {
        const msgDiv = document.createElement('div');
        msgDiv.classList.add('message', sender);
        
        // Convert newlines to <br>
        const formattedText = text.replace(/\n/g, '<br>');
        
        const time = new Date();
        const timeString = time.getHours().toString().padStart(2, '0') + ':' + time.getMinutes().toString().padStart(2, '0');

        msgDiv.innerHTML = `
            ${formattedText}
            <span class="time">${timeString}</span>
        `;
        
        messagesContainer.appendChild(msgDiv);
        scrollToBottom();
    }

    function scrollToBottom() {
        // Scroll to the bottom of the messages container
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function showTyping(show) {
        if (show) {
            typingIndicator.style.display = 'block';
            messagesContainer.appendChild(typingIndicator);
            scrollToBottom();
        } else {
            typingIndicator.style.display = 'none';
        }
    }

    function resetChat() {
        if (confirm('Hapus semua obrolan?')) {
            const time = new Date();
            const timeString = time.getHours().toString().padStart(2, '0') + ':' + time.getMinutes().toString().padStart(2, '0');
            
            messagesContainer.innerHTML = `
            <div class="message ai">
                Halo, ${username}! Aku sahabat virtualmu. Apa yang sedang kamu rasakan hari ini? Ceritain aja, aku di sini buat dengerin tanpa menghakimi. 😊
                <span class="time">${timeString}</span>
            </div>`;
        }
    }

    // --- JURNAL LOGIC ---
    function saveJurnalEntry() {
        const content = jurnalText.value.trim();
        if (!content) {
            alert('Tulis sesuatu dulu ya di jurnalmu.');
            return;
        }

        const entry = {
            id: Date.now(),
            date: new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }),
            content: content
        };

        let entries = getJurnalEntries();
        entries.unshift(entry); // Add new entry to the top
        localStorage.setItem('tc_jurnal_entries', JSON.stringify(entries));

        jurnalText.value = '';
        loadJurnal();
        alert('Catatan berhasil disimpan!');
    }

    function getJurnalEntries() {
        const entries = localStorage.getItem('tc_jurnal_entries');
        return entries ? JSON.parse(entries) : [];
    }

    function loadJurnal() {
        const entries = getJurnalEntries();
        jurnalList.innerHTML = '';

        if (entries.length === 0) {
            jurnalList.innerHTML = '<p style="color: #888; text-align: center; margin-top: 20px;">Belum ada catatan.</p>';
            return;
        }

        entries.forEach(entry => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('jurnal-item');
            itemDiv.innerHTML = `
                <div class="jurnal-date">${entry.date}</div>
                <div class="jurnal-content">${entry.content.replace(/\n/g, '<br>')}</div>
            `;
            jurnalList.appendChild(itemDiv);
        });
    }

    // --- SETTINGS LOGIC ---
    function saveSettings() {
        const newName = usernameInput.value.trim();
        if (newName) {
            username = newName;
            localStorage.setItem('tc_username', username);
            alert('Pengaturan berhasil disimpan!');
            
            // Update greeting logic if needed, currently just updates variable
        } else {
            alert('Nama tidak boleh kosong.');
        }
    }

    function loadSettings() {
        usernameInput.value = username;
    }
});
