<?php
error_reporting(0); // Impede que avisos PHP quebrem o JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    // Selecionamos apenas o necessário. Se o descriptor for NULL, enviamos string vazia
    $query = "SELECT id, url, IFNULL(descriptor, '') as descriptor FROM fotos ORDER BY id DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($photos);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>