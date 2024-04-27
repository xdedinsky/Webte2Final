<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../../../configFinal.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['passwordReg'];
    $role = 'user';  // Prednastavená rola

    if (!empty($username) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (username, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
            if ($stmt->execute()) {
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $conn->insert_id; // Dostupné len ak je user_id AUTO_INCREMENT
                $_SESSION["username"] = $username;
                header("location: /Webte2Final/src/index.php?action=register-success"); // Redirect to login page
            } else {
                header("location: /Webte2Final/src/index.php?action=register-failed");
            }
            $stmt->close();
        }
    } else {
        $error = "Please fill all the required fields.";
    }
    $conn->close();
}
?>
