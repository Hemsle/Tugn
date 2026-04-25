<?php
//api/saveWorkout.php
session_start();
header("Content-Type: application/json");
require_once('../inc/db.inc.php'); // Din PDO-anslutning ($db)

// 1. Kontrollera inloggning
if (!isset($_SESSION['uid'])) {
    echo json_encode(["status" => "error", "message" => "Användare ej inloggad"]);
    exit;
}

$uid = $_SESSION['uid'];
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Ingen data mottagen"]);
    exit;
}

try {
    $db->beginTransaction();

    // 2. Spara huvudpasset
    $stmt = $db->prepare("INSERT INTO workouts (uid, name, duration, volume, sets, date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $uid,
        $data['name'] ?? 'Workout',
        $data['duration'] ?? 0,
        $data['volume'] ?? 0,
        $data['sets'] ?? 0,
        $data['date'] ?? date('Y-m-d')
    ]);

    $workout_db_id = $db->lastInsertId();

    // 3. Loopa igenom övningar
    foreach ($data['exercises'] as $index => $ex) {
        $stmtEx = $db->prepare("INSERT INTO workout_exercises (workout_id, exercise_id, exercise_name, exercise_order) VALUES (?, ?, ?, ?)");
        $stmtEx->execute([
            $workout_db_id,
            $ex['id'], // ID från din exercises-tabell
            $ex['name'],
            $index
        ]);
        $exercise_db_id = $db->lastInsertId();

        // 4. Loopa igenom set
        foreach ($ex['sets'] as $setIndex => $set) {
            // Vi sparar bara set som är markerade som klara
            if (isset($set['completed']) && $set['completed']) {
                $stmtSet = $db->prepare("INSERT INTO workout_sets (exercise_id, weight, reps, duration, set_order) VALUES (?, ?, ?, ?, ?)");

                // Hantera värden beroende på om det är styrka eller cardio
                $weight = ($set['weight'] !== "") ? $set['weight'] : null;
                $reps = ($set['reps'] !== "") ? $set['reps'] : null;
                $duration = (isset($set['duration']) && $set['duration'] !== "") ? $set['duration'] : null;

                $stmtSet->execute([
                    $exercise_db_id,
                    $weight,
                    $reps,
                    $duration,
                    $setIndex
                ]);
            }
        }
    }

    $db->commit();
    echo json_encode(["status" => "success", "message" => "Träningspasset har sparats!"]);
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(["status" => "error", "message" => "Systemfel: " . $e->getMessage()]);
}
