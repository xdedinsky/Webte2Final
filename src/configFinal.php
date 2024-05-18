<?php
$servername = "mysql";
$username = "xtaborsky";
$password = "webte2";
$dbname = "webteFinal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>