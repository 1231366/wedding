<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $file = $_FILES['foto'];
    
    // No Mac/Linux, usamos a barra normal /
    $upload_dir = dirname(__DIR__) . '/uploads/';
    
    // Verifica se a pasta existe
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $new_name = bin2hex(random_bytes(10)) . "." . $ext;
    $target = $upload_dir . $new_name;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        try {
            $public_url = "uploads/" . $new_name;
            $query = "INSERT INTO fotos (url, facial_id) VALUES (:url, NULL)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':url', $public_url);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "url" => $public_url]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro DB: " . $e->getMessage()]);
        }
    } else {
        // Diagnóstico para Mac
        echo json_encode([
            "error" => "Permissão negada no Mac",
            "check" => "Executa 'chmod -R 777 uploads' no terminal dentro da pasta do projeto",
            "path_tentado" => $target,
            "writable" => is_writable($upload_dir)
        ]);
    }
} else {
    echo json_encode(["error" => "Ficheiro não recebido"]);
}