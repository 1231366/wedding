<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $file = $_FILES['foto'];
    
    // 1. Validações de Segurança
    $max_size = 5 * 1024 * 1024; // 5MB
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
    $file_info = pathinfo($file['name']);
    $extension = strtolower($file_info['extension']);

    if ($file['size'] > $max_size) {
        echo json_encode(["error" => "Ficheiro demasiado grande (Máx 5MB)"]);
        exit;
    }

    if (!in_array($extension, $allowed_extensions)) {
        echo json_encode(["error" => "Formato não suportado"]);
        exit;
    }

    // 2. Caminhos
    $upload_dir = "../uploads/";
    // Gerar nome único para evitar conflitos e ataques de overwrite
    $unique_name = bin2hex(random_bytes(10)) . "." . $extension;
    $target_path = $upload_dir . $unique_name;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        try {
            // Guardamos o caminho que o frontend vai usar para exibir (relativo à raiz)
            $public_url = "uploads/" . $unique_name;
            
            $query = "INSERT INTO fotos (url) VALUES (:url)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':url', $public_url);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "success" => true, 
                    "message" => "Upload concluído",
                    "url" => $public_url
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro na base de dados: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Falha ao mover ficheiro"]);
    }
} else {
    echo json_encode(["error" => "Pedido inválido"]);
}