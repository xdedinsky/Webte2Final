<?php
require '../../../../configFinal.php';

if (isset($_GET['question_id']) && isset($_GET['active'])) {

    $questionId = $_GET['question_id'];
    $current_active = $_GET['active'];

    if ($current_active !== null) {
    
        $new_active = $current_active == 1 ? 0 : 1;
        echo "qid = ", $questionId;
        echo "new active", $new_active;
        $sql_update_active = "UPDATE Questions SET active = ? WHERE question_id = ?";
        $stmt_update_active = $conn->prepare($sql_update_active);
        $stmt_update_active->bind_param("ii", $new_active, $questionId);
        if ($stmt_update_active->execute()) {
            echo "Stav 'active' otázky s ID $questionId bol úspešne aktualizovaný.";
        } else {
            echo "Aktualizácia stavu 'active' otázky zlyhala: " . $stmt_update_active->error;
        }
        header('Location: ../index.php');
        exit;
    }
} else {
    exit;
}

?>