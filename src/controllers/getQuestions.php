<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../../../configFinal.php';
$username = $_SESSION["username"];
$sql = "SELECT user_id, role FROM Users WHERE username = :username ";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Výpis výsledkov (pre demonštračné účely)
print_r($result);
$conn =null;
//header('Content-Type: application/json');
//echo json_encode($result);






?>