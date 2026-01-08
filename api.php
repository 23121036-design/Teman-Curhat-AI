<?php
header('Content-Type: application/json');
require_once 'config.php';

// Mendapatkan data JSON dari request body
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['message'])) {
    echo json_encode(['success' => false, 'error' => 'No message provided']);
    exit;
}

$userMessage = $input['message'];
$username = isset($input['username']) ? $input['username'] : 'Teman';

// Setup Pesan System (Personality)
// Ini kunci agar AI bertindak seperti teman curhat, bukan robot kaku.
$systemPrompt = "Kamu adalah 'Teman Curhat', sahabat virtual yang sangat empatik, pendengar yang baik, dan suportif. 
Panggil pengguna dengan nama: '$username'.
Gunakan bahasa Indonesia yang gaul, santai, dan akrab (seperti 'aku-kamu' atau 'gue-lo' tapi sopan). 
Jangan memberikan nasihat teknis yang kaku. Fokus pada perasaan pengguna.
Jawabanmu harus terasa manusiawi, hangat, dan kadang berikan sedikit humor jika cocok.
Jangan terlalu panjang lebar seperti artikel, jawablah seperti chat WA antar sahabat.";

// Data payload untuk OpenRouter
$data = [
    "model" => "google/gemini-2.0-flash-exp:free", // Menggunakan model SOTA yang tersedia di OpenRouter (Gratis untuk saat ini)
    // Alternatif berbayar yg bagus: "openai/gpt-3.5-turbo", "anthropic/claude-3-haiku"
    "messages" => [
        ["role" => "system", "content" => $systemPrompt],
        ["role" => "user", "content" => $userMessage]
    ],
    "top_p" => 1,
    "temperature" => 0.8, // Agak kreatif dikit biar ga kaku
    "repetition_penalty" => 1
];

// cURL Request ke OpenRouter
$ch = curl_init("https://openrouter.ai/api/v1/chat/completions");

$headers = [
    "Authorization: Bearer " . OPENROUTER_API_KEY,
    "Content-Type: application/json",
    "HTTP-Referer: " . SITE_URL, // Wajib untuk OpenRouter
    "X-Title: " . APP_NAME
];

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Disable SSL verification for localhost development ease (Not recommended for production)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(['success' => false, 'error' => curl_error($ch)]);
} else {
    // Decode response
    $result = json_decode($response, true);

    if ($httpCode === 200 && isset($result['choices'][0]['message']['content'])) {
        echo json_encode([
            'success' => true,
            'reply' => $result['choices'][0]['message']['content']
        ]);
    } else {
        // Coba tangkap error dari API jika ada
        $errorMsg = isset($result['error']['message']) ? $result['error']['message'] : 'Unknown API Error';
        echo json_encode(['success' => false, 'error' => $errorMsg]);
    }
}

curl_close($ch);
?>