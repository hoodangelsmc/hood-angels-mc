<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get Authorization header
$auth_header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$password = '';
if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    $password = $matches[1];
}

// Verify password
if ($password !== 'scorpion123') {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Yetkisiz erişim"]);
    exit;
}

// Get input JSON
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data || !isset($data['file']) || !isset($data['content'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Geçersiz veri formatı"]);
    exit;
}

// Security: Only allow specific JSON files
$allowed_files = ['gallery_data.json', 'trash_data.json'];
$filename = basename($data['file']);

if (!in_array($filename, $allowed_files)) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Bu dosyayı güncellemeye yetkiniz yok"]);
    exit;
}

// Target path: save in the assets directory
$target_path = __DIR__ . '/../assets/' . $filename;

// Format JSON cleanly with UTF-8
$content = json_encode($data['content'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

if (file_put_contents($target_path, $content) !== false) {
    echo json_encode(["status" => "success", "message" => "$filename başarıyla yerel sunucuya kaydedildi"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Dosya yerel sunucuya yazılamadı"]);
}
