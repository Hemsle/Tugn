<?php
session_start();
require_once("../inc/db.inc.php");

$follower_id = $_SESSION['uid'];
$following_id = $_POST['following_id'];

$stmt = $db->prepare("SELECT 1 FROM user_follows WHERE follower_id = ? AND following_id = ?");
$stmt->execute([$follower_id, $following_id]);

if ($stmt->fetch()) {
    // sluta följa
    $stmt = $db->prepare("DELETE FROM user_follows WHERE follower_id = ? AND following_id = ?");
    $stmt->execute([$follower_id, $following_id]);
    echo json_encode(["status" => "unfollowed"]);
} else {
    // börja följa
    $stmt = $db->prepare("INSERT INTO user_follows (follower_id, following_id, followed_at) VALUES (?, ?, NOW())");
    $stmt->execute([$follower_id, $following_id]);
    echo json_encode(["status" => "followed"]);
}
