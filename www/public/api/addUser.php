<?php
// www/public/api/addUser.php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once('../inc/db.inc.php');

$result = ['success' => false, 'message' => 'Något gick fel'];

// Validera indata 
$firstname = trim($_POST['firstname'] ?? '');
$surname   = trim($_POST['surname'] ?? '');
$username  = trim($_POST['username'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';

if (empty($firstname) || empty($surname) || empty($username) || empty($email) || strlen($password) < 6) {
    $result['message'] = 'Vänligen fyll i alla fält korrekt (lösenord minst 6 tecken)';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Kontrollera om användarnamn eller email redan finns
    $checkStmt = $db->prepare("SELECT uid FROM user WHERE username = ? OR email = ?");
    $checkStmt->execute([$username, $email]);
    if ($checkStmt->fetch()) {
        $result['message'] = 'Användarnamnet eller e-postadressen är redan tagen';
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    //  Förbered data för din tabellstruktur
    //  saknar firstname/surname sparar vi dem i display_name
    $displayName = $firstname . " " . $surname;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, password, email, display_name) VALUES (:user, :pass, :email, :name)";
    $stmt = $db->prepare($sql);

    $inserted = $stmt->execute([
        ':user'  => $username,
        ':pass'  => $hashedPassword,
        ':email' => $email,
        ':name'  => $displayName
    ]);

    if ($inserted) {
        $result['success'] = true;
        $result['message'] = 'Användare skapad';
    }
} catch (PDOException $e) {
    $result['message'] = 'Databasfel: ' . $e->getMessage();
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
