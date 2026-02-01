<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    // Busca as fotos usando a coluna data_upload que tens na DB
    $query = "SELECT id, url FROM fotos ORDER BY data_upload DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($photos);
} catch (PDOException $e) {
    echo json_encode(["error" => "Erro na base de dados: " . $e->getMessage()]);
}