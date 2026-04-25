<?php
session_start();

header('Content-Type: application/json');
require_once('../inc/db.inc.php');

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

try {
    //Söker användare som innehåller söksträngen
    $stmt = $db->prepare("SELECT uid, username, display_name 
        FROM user WHERE username LIKE :q OR display_name LIKE :q LIMIT 8;");

    $searchTerm = "%" . $query . "%";
    $stmt->bindValue(':q', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}