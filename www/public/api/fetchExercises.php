<?php
// fetchDB.php - Fetches all exercises from the database and returns them as JSON
require_once '../inc/db.inc.php'; // Include the database connection

header('Content-Type: application/json');

try {
    // Ensure the $db object is available
    if (!isset($db)) {
        throw new Exception('Database connection not initialized.');
    }

    // Query to fetch all exercises
    $stmt = $db->query('SELECT * FROM exercises ORDER BY muscle, exercise_type, difficulty');
    $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode([
        'success' => true,
        'exercises' => $exercises
    ]);
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    // Handle other errors
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
