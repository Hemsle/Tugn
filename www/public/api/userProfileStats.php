<?php
session_start();

header('Content-type: application/json');

require_once("../inc/db.inc.php");

//Identifiera vilken användare vi ska hämta data för
$username = $_GET['username'] ?? null;
$targetUid = null;

if ($username) {
    // Om ett användarnamn skickas med, hämta UID för den profilen
    $stmt = $db->prepare("SELECT uid, username, display_name, bio FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        echo json_encode(["error" => "Användaren hittades inte"]);
        exit;
    }
    $targetUid = $userData['uid'];
} elseif (isset($_SESSION['uid'])) {
    // Om inget användarnamn skickas, använd den inloggade användarens eget UID
    $targetUid = $_SESSION['uid'];
    $userData = null;
} else {
    echo json_encode(["error" => "Ej inloggad"]);
    exit;
}

// Inställningar för pagination
$limit = 10;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Hämta de relevanta träningspassens ID för mål-användaren
$stmtIds = $db->prepare("SELECT id FROM workouts WHERE uid = :uid ORDER BY date DESC, created_at DESC LIMIT :limit OFFSET :offset");
$stmtIds->bindValue(':uid', $targetUid, PDO::PARAM_STR);
$stmtIds->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmtIds->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtIds->execute();
$workoutIds = $stmtIds->fetchAll(PDO::FETCH_COLUMN);

if ($username) {
    $followersQuery = $db->prepare('
    SELECT u.username, u.display_name, u.uid 
    FROM user u
    JOIN user_follows f ON u.uid = f.follower_id
    WHERE f.following_id = ?
');
    $followersQuery->execute([$targetUid]);
    $userData['followers'] = $followersQuery->fetchAll(PDO::FETCH_ASSOC);

    $followingQuery = $db->prepare('
    SELECT u.username, u.display_name, u.uid
    FROM user u
    JOIN user_follows f ON u.uid = f.following_id 
    WHERE f.follower_id = ?');
    $followingQuery->execute([$targetUid]);
    $userData['following'] = $followingQuery->fetchAll(PDO::FETCH_ASSOC);

    $workoutCountStmt = $db->prepare('SELECT COUNT(*) FROM workouts WHERE uid = ?');
    $workoutCountStmt->execute([$targetUid]);
    $userData['workoutCount'] = (int)$workoutCountStmt->fetchColumn();
}

$isFollowing = false;
if (isset($_SESSION['uid']) && $targetUid !== $_SESSION['uid']) {
    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM user_follows WHERE follower_id = ? AND following_id = ?");
    $stmtCheck->execute([$_SESSION['uid'], $targetUid]);

    // Om count är större än 0 så följer användaren
    $isFollowing = $stmtCheck->fetchColumn() > 0;
}

if (empty($workoutIds)) {
    echo json_encode([
        "user" => $userData,
        "workouts" => [],
        "isFollowing" => $isFollowing
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

//Hämta detaljerad data för träningspassen
$placeholders = implode(',', array_fill(0, count($workoutIds), '?'));

$query = "
        SELECT 
            w.id AS workout_id, 
            w.name AS workout_name, 
            w.date, 
            w.duration, 
            w.volume,
            w.sets, 
            we.id AS ex_id, 
            we.exercise_name, 
            we.exercise_order,
            ws.weight, 
            ws.reps, 
            ws.duration AS set_duration, 
            ws.set_order, 
            ws.completed
        FROM workouts w
        LEFT JOIN workout_exercises we ON w.id = we.workout_id
        LEFT JOIN workout_sets ws ON we.id = ws.exercise_id
        WHERE w.id IN ($placeholders)
        ORDER BY w.date DESC, w.created_at DESC, we.exercise_order ASC, ws.set_order ASC
    ";

$stmt = $db->prepare($query);
$stmt->execute($workoutIds);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Strukturera datan
$history = [];
foreach ($rows as $row) {
    $wId = $row['workout_id'];
    $eId = $row['ex_id'];

    if (!isset($history[$wId])) {
        $history[$wId] = [
            'id' => $wId,
            'name' => $row['workout_name'],
            'date' => $row['date'],
            'duration' => $row['duration'],
            'volume' => $row['volume'],
            'sets' => $row['sets'],
            'exercises' => []
        ];
    }
    if ($eId && !isset($history[$wId]['exercises'][$eId])) {
        $history[$wId]['exercises'][$eId] = [
            'name' => $row['exercise_name'],
            'sets' => []
        ];
    }
    if ($eId) {
        $history[$wId]['exercises'][$eId]['sets'][] = [
            'weight' => $row['weight'],
            'reps' => $row['reps'],
            'duration' => $row['set_duration'],
            'completed' => (bool)$row['completed']
        ];
    }
}

// Formatera om för JSON-array
foreach ($history as &$workout) {
    $workout['exercises'] = array_values($workout['exercises']);
}

$formattedWorkouts = array_values($history);

// Returnera både användarinfo och träningspass

if ($username) {
    echo json_encode([
        "user" => $userData,
        "workouts" => $formattedWorkouts,
        "isFollowing" => $isFollowing
    ], JSON_UNESCAPED_UNICODE);
} else {
    //för egen sida, endast array för träningspass då locals.user redan finns i svelte
    echo json_encode([
        "workouts" => $formattedWorkouts,
    ], JSON_UNESCAPED_UNICODE);
}
