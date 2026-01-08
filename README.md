# Teman Curhat AI

**Teman Curhat AI** adalah aplikasi web sederhana berbasis PHP yang berfungsi sebagai sahabat virtual untuk mendengarkan curhatanmu. Didukung oleh kecerdasan buatan (AI) via OpenRouter, aplikasi ini dirancang untuk memberikan respons yang empatik, suportif, dan layaknya seorang teman dekat.

## Fitur Unggulan

*   **Sahabat AI yang Empatik**: Menggunakan model AI canggih (**Gemini 2.0 Flash**) yang diinstruksikan untuk menjadi pendengar yang baik dan merespons dengan bahasa santai.
*   **Personalisasi**: AI akan memanggilmu dengan nama panggilan yang kamu atur di menu Pengaturan.
*   **SPA (Single Page Application)**: Navigasi antar menu (Chat, Jurnal, Pengaturan) berjalan lancar tanpa *reload* halaman.
*   **Jurnal Harian**: Fitur untuk menulis dan menyimpan catatan harianmu (disimpan secara lokal di browser).
*   **Desain Estetik**: Antarmuka modern yang tenang dan nyaman dipandang (Glassmorphism style).

## Teknologi

*   **Backend**: PHP (untuk routing API sederhana ke OpenRouter)
*   **Frontend**: HTML5, CSS3 (Vanilla), JavaScript (Vanilla)
*   **AI Provider**: OpenRouter API
*   **Icons**: Phosphor Icons

## Cara Install & Menjalankan

### Prasyarat
Pastikan komputer kamu sudah terinstall **PHP**.

### Langkah-langkah

1.  **Clone atau Download** folder proyek ini.
2.  **Konfigurasi API Key**:
    *   Buka file `config.php`.
    *   Pastikan `OPENROUTER_API_KEY` sudah terisi dengan API Key yang valid.
    *   *(Catatan: Jangan pernah upload API Key asli ke repository publik!)*
3.  **Jalankan Server PHP**:
    *   Buka terminal/command prompt di dalam folder proyek.
    *   Ketik perintah berikut:
        ```bash
        php -S localhost:8000
        ```
4.  **Buka Aplikasi**:
    *   Buka browser (Chrome/Edge/Firefox).
    *   Kunjungi alamat: `http://localhost:8000`

## Cara Menggunakan

1.  **Chat Utama**: Ketik curhatanmu di kolom pesan dan tekan enter/kirim. AI akan membalas.
2.  **Jurnal**: Masuk ke menu Jurnal untuk menulis perasaanmu hari ini. Klik "Simpan" agar tidak hilang.
3.  **Pengaturan**: Ubah nama panggilanmu di sini agar AI lebih akrab.
4.  **Reset Chat**: Klik ikon tempat sampah di pojok kanan atas chat untuk menghapus riwayat obrolan.

---
*Dibuat untuk Tugas Akhir STI.*
