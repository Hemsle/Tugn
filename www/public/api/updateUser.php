<?php
session_start();
require_once('../inc/db.inc.php');
header('Content-Type: application/json');

$uid = $_SESSION['uid'];

$displayName = trim($_POST['displayName'] ?? '');
$username    = trim($_POST['username'] ?? '');
$email       = trim($_POST['email'] ?? '');
$bio         = trim($_POST['bio'] ?? '');
$newPass     = $_POST['newPassword'] ?? '';
$repeatedPass = $_POST['repeatedPass'] ?? '';
$confirmPass = $_POST['confirmPassword'] ?? '';

if (!empty($newPass) && empty($repeatedPass)) {
    $result['message'] = "You must repeat your new password";
    echo json_encode($result);
    exit;
}

if (empty($confirmPass)) {
    $result['message'] = "You must enter your current password to save changes";
    echo json_encode($result);
    exit;
}

if($newPass != $repeatedPass) {
    $result['message'] = "Repeated password has to match the new";
    echo json_encode($result);
    exit;
}

$stmt = $db->prepare("SELECT password FROM user WHERE uid = ?");
$stmt->execute([$uid]);
$user = $stmt->fetch();

if (!$user || !password_verify($confirmPass, $user['password'])) {
    $result['message'] = 'Wrong password';
    echo json_encode($result);
    exit;
}

if (!empty($username) || !empty($email)) {
    $checkStmt = $db->prepare("SELECT uid FROM user WHERE (username = ? OR email = ?) AND uid != ?");
    $checkStmt->execute([$username, $email, $uid]);
    if ($checkStmt->fetch()) {
        $result['message'] = 'Username or mail already taken';
        echo json_encode($result);
        exit;
    }
}

$updates = [];
$params = [];

if (!empty($displayName)) {
    $updates[] = "display_name = ?";
    $params[] = $displayName;
}
if (!empty($username)) {
    $updates[] = "username = ?";
    $params[] = $username;
}
if (!empty($email)) {
    $updates[] = "email = ?";
    $params[] = $email;
}
if (isset($_POST['bio'])) {
    $updates[] = "bio = ?";
    $params[] = $bio;
}
if (!empty($newPass)) {
    if (strlen($newPass) < 6) {
        $result['message'] = 'At least 6 characters for password';
        echo json_encode($result);
        exit;
    }
    $updates[] = "password = ?";
    $params[] = password_hash($newPass, PASSWORD_DEFAULT);
}

if (empty($updates)) {
    $result['message'] = 'Inga ändringar angivna';
    echo json_encode($result);
    exit;
}

$params[] = $uid;
$sql = "UPDATE user SET " . implode(', ', $updates) . " WHERE uid = ?";
$updateStmt = $db->prepare($sql);

if ($updateStmt->execute($params)) {
    $result['success'] = true;
    $result['message'] = 'Profile updated';
}

echo json_encode($result);
