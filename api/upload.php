<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

// Suporte para múltiplos ficheiros ou ficheiro único
$files = [];
if (isset($_FILES['fotos'])) {
    foreach ($_FILES['fotos']['name'] as $i => $name) {
        $files[] = [
            'name' => $name,
            'tmp_name' => $_FILES['fotos']['tmp_name'][$i],
            'descriptor' => $_POST['descriptors'][$i] ?? null
        ];
    }
} elseif (isset($_FILES['foto'])) {
    $files[] = [
        'name' => $_FILES['foto']['name'],
        'tmp_name' => $_FILES['foto']['tmp_name'],
        'descriptor' => $_POST['descriptor'] ?? null
    ];
}

$results = [];
foreach ($files as $file) {
    $upload_dir = dirname(__DIR__) . '/uploads/';
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $new_name = bin2hex(random_bytes(10)) . "." . $ext;
    $target = $upload_dir . $new_name;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        try {
            $public_url = "uploads/" . $new_name;
            $query = "INSERT INTO fotos (url, descriptor) VALUES (:url, :descriptor)";
            $stmt = $db->prepare($query);
            $stmt->execute([':url' => $public_url, ':descriptor' => $file['descriptor']]);
            $results[] = ["success" => true, "url" => $public_url];
        } catch (PDOException $e) { $results[] = ["error" => "DB Error"]; }
    }
}

echo json_encode(["results" => $results]);