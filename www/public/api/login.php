<?php
// www/public/api/login.php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once('../inc/db.inc.php');

$result = ['success' => false, 'message' => 'Something went wrong'];

$nameOrMail = trim($_POST['nameOrMail'] ?? '');
$password  = $_POST['password'] ?? '';

if (empty($nameOrMail) || empty($password)) {
    $result['message'] = 'Fill in all fields accordingly';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $stmt = $db->prepare("SELECT * FROM user WHERE username = ? OR email = ? LIMIT 1");
    $stmt->execute([$nameOrMail, $nameOrMail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {

            $_SESSION['uid'] = $user['uid'];
            $_SESSION['username'] = $user['username'];

            $result['success'] = true;
            $result['message'] = 'Succesful login';
        } else {
            $result['message'] = 'Wrong password';
        }
    } else {
        $result['message'] = 'No user';
    }

} catch (PDOException $e) {
    $result['message'] = 'Server problem: ' . $e->getMessage();
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
