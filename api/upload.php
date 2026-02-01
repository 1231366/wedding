<?php
error_reporting(E_ALL); // Ativar erros para debug
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

$results = [];

if (isset($_FILES['fotos'])) {
    foreach ($_FILES['fotos']['name'] as $i => $name) {
        $upload_dir = dirname(__DIR__) . '/uploads/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $new_name = bin2hex(random_bytes(10)) . "." . $ext;
        $target = $upload_dir . $new_name;

        if (move_uploaded_file($_FILES['fotos']['tmp_name'][$i], $target)) {
            try {
                $public_url = "uploads/" . $new_name;
                // Recebemos o JSON do JS e guardamos tal como está (Array de Arrays)
                $descriptor = $_POST['descriptors'][$i] ?? null;
                
                $query = "INSERT INTO fotos (url, descriptor) VALUES (:url, :descriptor)";
                $stmt = $db->prepare($query);
                $stmt->execute([':url' => $public_url, ':descriptor' => $descriptor]);
                $results[] = ["success" => true, "url" => $public_url];
            } catch (PDOException $e) { 
                $results[] = ["error" => $e->getMessage()]; 
            }
        }
    }
}

echo json_encode(["results" => $results]);