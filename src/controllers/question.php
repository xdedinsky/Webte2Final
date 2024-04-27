<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../../../configFinal.php'; 

// Read the JSON POST body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate input data
if (!isset($data['question_text']) || !isset($data['question_type'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid input data']);
    exit;
}

// Insert query
$stmt = $conn->prepare("INSERT INTO Questions (user_id, question_text, question_type, active, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
$stmt->bind_param("issi", $_SESSION['user_id'], $data['question_text'], $data['question_type'], $active);

// Set active to 1 (true)
$active = 1;

// Execute and check for errors
if (!$stmt->execute()) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

$question_id = $stmt->insert_id;
$stmt->close();

// Handle options if the question type is multiple_choice
if ($data['question_type'] == 'multiple_choice') {
    foreach ($data['options'] as $option) {
        $stmt = $conn->prepare("INSERT INTO QuestionOptions (question_id, option_text) VALUES (?, ?)");
        $stmt->bind_param("is", $question_id, $option);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

// Success response
http_response_code(200);
echo json_encode(['success' => 'Question submitted successfully']);
?>
