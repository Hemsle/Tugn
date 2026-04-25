<?php
// www/public/import.php
require_once '../inc/db.inc.php';

header('Content-Type: application/json');

$apiKey = "hSPjo6dvdgFyNfRBO7EVRQ==31s6QTzAQhWCWldf";
$muscleGroups = [
    'abdominals',
    'abductors',
    'adductors',
    'biceps',
    'calves',
    'chest',
    'forearms',
    'glutes',
    'hamstrings',
    'lats',
    'lower_back',
    'middle_back',
    'neck',
    'quadriceps',
    'traps',
    'triceps'
];

$count = 0;


foreach ($muscleGroups as $muscle) {
    $url = "https://api.api-ninjas.com/v1/exercises?muscle=" . $muscle;
    
    $options = [
        "http" => [
            "header" => "X-Api-Key: " . $apiKey
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $exercises = json_decode($response, true);

    if ($exercises) {
        foreach ($exercises as $ex) {
            $sql = "INSERT INTO exercises (name, muscle, equipment_json, exercise_type, difficulty, instructions, safety_info) 
                    VALUES (:name, :muscle, :equip, :type, :diff, :instr, :safe)
                    ON DUPLICATE KEY UPDATE name=name";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name'   => $ex['name'],
                ':muscle' => $ex['muscle'],
                ':equip'  => json_encode($ex['equipments']), // Spara array som JSON
                ':type'   => $ex['type'],
                ':diff'   => $ex['difficulty'],
                ':instr'  => $ex['instructions'],
                ':safe'   => $ex['safety_info'] ?? ''
            ]);
            $count++;
        }
    }
}

echo json_encode(["success" => true, "message" => "Importerade $count övningar via PHP."]);
