<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../../../configFinal.php';  // Ensure this path is correct

// This script should receive JSON data
$input = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'] ?? null; // Allow null if not logged in
$question_id = $input['question_id'] ?? null;
$answer = $input['answer'] ?? null;

if (!$question_id || !$answer) {
    // Output error if the necessary data is missing
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Missing question ID or answer']);
    exit;
}

// First, get the type of the question from the database
if ($questionStmt = $conn->prepare("SELECT question_type FROM Questions WHERE question_id = ?")) {
    $questionStmt->bind_param("i", $question_id);
    $questionStmt->execute();
    $questionResult = $questionStmt->get_result();
    $questionData = $questionResult->fetch_assoc();
    $questionStmt->close();

    if (!$questionData) {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Question not found']);
        exit;
    }

    $question_type = $questionData['question_type'];
    $option_id = null;
    $response_text = '';

    // Determine whether to record an option_id or response_text based on question type
    if ($question_type == 'multiple_choice') {
        $option_id = $answer;  // Directly use answer as option_id for multiple choice
    } else if ($question_type == 'open_ended') {
        $response_text = $answer;  // Use answer as response text for open-ended
    }

    // Insert the answer into the Responses table
    if ($insertStmt = $conn->prepare("INSERT INTO Responses (question_id, user_id, option_id, response_text, created_at) VALUES (?, ?, ?, ?, NOW())")) {
        $user_id = $_SESSION['user_id'] ?? 0;  // Default to 0 or handle accordingly if user is not logged in

        if ($user_id > 0) {
            // If a valid user_id exists, proceed with the insertion
            $insertStmt->bind_param("iiis", $question_id, $user_id, $option_id, $response_text);
        } else {
            // If no valid user_id, handle the NULL scenario
            $insertStmt->bind_param("iiis", $question_id, $null, $option_id, $response_text);
        }
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            echo json_encode(['success' => 'Response submitted successfully']);
        } else {
            // Output error if the insert failed
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Failed to submit response']);
        }
        $insertStmt->close();
    } else {
        // Output SQL error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $conn->error]);
    }
} else {
    // Output SQL error when querying question type
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>
