<?php
//session.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['uid'])) {
    echo json_encode(null);
    exit;
}

require_once( '../inc/db.inc.php');

$uid = $_SESSION['uid'];
$stmt = $db->prepare('SELECT uid, username, email, display_name, bio FROM user WHERE uid = ? LIMIT 1');
$stmt->execute([$uid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$followersQuery = $db->prepare('
    SELECT u.username, u.display_name, u.uid 
    FROM user u
    JOIN user_follows f ON u.uid = f.follower_id
    WHERE f.following_id = ?
');
$followersQuery->execute([$uid]);
$user['followers'] = $followersQuery->fetchAll(PDO::FETCH_ASSOC);

$followingQuery = $db->prepare('
    SELECT u.username, u.display_name, u.uid
    FROM user u
    JOIN user_follows f ON u.uid = f.following_id 
    WHERE f.follower_id = ?');
$followingQuery->execute([$uid]);
$user['following'] = $followingQuery->fetchAll(PDO::FETCH_ASSOC);

$workoutCountStmt = $db->prepare('SELECT COUNT(*) FROM workouts WHERE uid = ?');
$workoutCountStmt->execute([$uid]);
$user['workoutCount'] = (int)$workoutCountStmt->fetchColumn();

echo json_encode($user, JSON_UNESCAPED_UNICODE);

