<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../../../configFinal.php';

// Funkcia na export otázok a odpovedí vo formáte JSON
// Funkcia na export otázok a odpovedí vo formáte JSON
function exportQuestionsAndResponses($userId, $conn) {
    // Overenie pripojenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Pole pre ukladanie otázok a odpovedí vo formáte JSON
    $questionsAndResponses = [];

    // Pre admina získa všetky otázky a odpovede
    if ($_SESSION['role'] == 'admin') {
        $sql = "SELECT * FROM Questions";
    } else { // Pre používateľa získa iba jeho otázky a odpovede
        $sql = "SELECT * FROM Questions WHERE user_id = $userId";
    }

    // Vykonanie SQL dotazu na otázky
    $result = $conn->query($sql);

    // Spracovanie výsledkov
    if ($result->num_rows > 0) {
        // Pre každý riadok výsledku (otázka)
        while($row = $result->fetch_assoc()) {
            $question = [
                "question_id" => $row["question_id"],
                "question_text" => $row["question_text"],
                "responses" => [] // Pole pre ukladanie odpovedí k otázke
            ];
            
            // Získa odpovede na túto otázku z tabuľky Responses
            $questionId = $row["question_id"];
            $responseSql = "SELECT * FROM Responses WHERE question_id = $questionId";
            
            // Pre admina alebo pre používateľa, ktorý položil otázku, získa odpovede
            if ($_SESSION['role'] == 'admin' || $row['user_id'] == $_SESSION['user_id']) {
                $responseResult = $conn->query($responseSql);

                // Ak sú odpovede k dispozícii, pridá ich do pola
                if ($responseResult->num_rows > 0) {
                    while($responseRow = $responseResult->fetch_assoc()) {
                        // Vytvorí pole pre odpoveď
                        $response = [
                            "response_text" => $responseRow["response_text"]
                        ];
                        
                        // Ak existuje možnosť v odpovedi, získa ju z tabuľky QuestionOptions
                        if ($responseRow["option_id"] != null) {
                            $optionId = $responseRow["option_id"];
                            $optionSql = "SELECT * FROM QuestionOptions WHERE option_id = $optionId";
                            $optionResult = $conn->query($optionSql);
                            
                            if ($optionResult->num_rows > 0) {
                                $optionRow = $optionResult->fetch_assoc();
                                $response["option_text"] = $optionRow["option_text"];
                            }
                        }
                        
                        // Pridá odpoveď do poľa odpovedí k otázke
                        $question["responses"][] = $response;
                    }
                }
            }
            
            // Pridá otázku do hlavného poľa
            $questionsAndResponses[] = $question;
        }
    }

    // Konvertuje pole otázok a odpovedí na JSON a vypíše ho
    $json =  json_encode($questionsAndResponses,  JSON_PRETTY_PRINT);
    // Hlavičky pre sťahovanie JSON súboru
    header('Content-Description: File Transfer');
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="questions_and_responses.json"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($json));

    // Vypíše JSON do výstupu (sťahuje súbor)
    echo $json;
}

// Zavolanie funkcie na export otázok a odpovedí
// Pre admina použije všetky otázky a odpovede
// Pre bežného používateľa iba jeho otázky a odpovede
if ($_SESSION['role'] == 'admin') {
    exportQuestionsAndResponses(null, $conn);
} else {
    exportQuestionsAndResponses($_SESSION['user_id'], $conn);
}

// Uzavretie pripojenia k databáze
$conn->close();
?>
