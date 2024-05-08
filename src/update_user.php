<?php
// Include your database connection file here
require '../../../configFinal.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Note: You might want to hash the password for security
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Prepare SQL statement to update user details
    $sql_update = "UPDATE Users SET username=?, password=?, email=?, role=? WHERE user_id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $username, $password, $email, $role, $user_id);

    // Execute the update statement
    if ($stmt_update->execute()) {
        // Update successful, redirect back to the page where the form was submitted
        header("Location: user_managment.php"); // Replace 'previous_page.php' with the actual page
        exit();
    } else {
        // Update failed, handle the error (e.g., display an error message)
        echo "Error updating user: " . $conn->error;
    }

    // Close statement
    $stmt_update->close();
}

// Close connection
$conn->close();
?>
