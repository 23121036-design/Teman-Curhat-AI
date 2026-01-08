<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo APP_NAME; ?>
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- Icon Library (Phosphor Icons - Ringan & Estetik) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <i class="ph-fill ph-chat-circle-dots" style="color: #764ba2;"></i>
                <span>TemanCurhat</span>
            </div>
            <nav>
                <div class="menu-item active" data-target="chat-section">
                    <i class="ph ph-chats"></i>
                    <span>Chat Utama</span>
                </div>
                <div class="menu-item" data-target="jurnal-section">
                    <i class="ph ph-notebook"></i>
                    <span>Jurnal</span>
                </div>
                <div class="menu-item" data-target="settings-section">
                    <i class="ph ph-gear"></i>
                    <span>Pengaturan</span>
                </div>
            </nav>
            <div style="margin-top: auto; font-size: 0.8rem; color: #aaa; text-align: center;">
                &copy; <?php echo date('Y'); ?> Tugas Akhir STI
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">

            <!-- SECTION: CHAT (Default) -->
            <section id="chat-section" class="content-section active">
                <header class="chat-header">
                    <div class="contact-info">
                        <h2>Sahabat AI</h2>
                        <p><span class="status-dot"></span> Online & Siap Mendengar</p>
                    </div>
                    <div class="actions">
                        <button class="menu-item" id="reset-chat-btn" style="border:none; background:transparent;"
                            title="Hapus Chat">
                            <i class="ph ph-trash" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </header>

                <div class="messages-container" id="messages-container">
                    <!-- Welcome Message -->
                    <div class="message ai">
                        Halo! Aku sahabat virtualmu. Apa yang sedang kamu rasakan hari ini? Ceritain aja, aku di sini
                        buat
                        dengerin tanpa menghakimi. 😊
                        <span class="time">
                                <?php echo date('H:i'); ?>
                        </span>
                    </div>
                </div>

                <div class="typing-indicator" id="typing-indicator">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>

                <div class="input-area">
                    <input type="text" id="chat-input" placeholder="Tulis curhatanmu di sini..." autocomplete="off">
                    <button id="send-btn">
                        <i class="ph-fill ph-paper-plane-right" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
            </section>

            <!-- SECTION: JURNAL -->
            <section id="jurnal-section" class="content-section hidden">
                <header class="chat-header">
                    <h2>Jurnal Harian</h2>
                </header>
                <div class="section-content">
                    <div class="jurnal-input">
                        <textarea id="jurnal-text"
                            placeholder="Tuliskan perasaanmu atau kejadian hari ini..."></textarea>
                        <button id="save-jurnal-btn" class="primary-btn">Simpan Catatan</button>
                    </div>
                    <div class="jurnal-list" id="jurnal-list">
                        <!-- Jurnal entries will appear here -->
                        <p style="color: #888; text-align: center; margin-top: 20px;">Belum ada catatan.</p>
                    </div>
                </div>
            </section>

            <!-- SECTION: PENGATURAN -->
            <section id="settings-section" class="content-section hidden">
                <header class="chat-header">
                    <h2>Pengaturan</h2>
                </header>
                <div class="section-content">
                    <div class="setting-item">
                        <label for="username-input">Nama Panggilan</label>
                        <input type="text" id="username-input" placeholder="Nama kamu...">
                        <button id="save-settings-btn" class="primary-btn">Simpan</button>
                    </div>
                    <div class="setting-item">
                        
                        <p style="font-size: 0.9rem; color: #666;">
                            Nama panggilan akan digunakan oleh Sahabat AI untuk menyapamu.
                        </p>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <script src="script.js"></script>
</body>

</html>