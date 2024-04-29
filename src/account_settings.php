<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOTE Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    

    <div class="container">
        <h2 localize = "change_pwd"></h2>
        <form id="changePasswordForm">
            <div class="form-group">
                <label><h2 localize="current_pwd"></h2></label>
                <input type="password" name="current_password" class="form-control <?php echo (!empty($current_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $current_password_err; ?></span>
            </div>    
            <div class="form-group">
                <label><h2 localize="new_pwd"></h2></label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label><h2 localize="conf_pwd"></h2></label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div> 


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>
<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = {
        current_password: document.getElementsByName('current_password')[0].value,
        new_password: document.getElementsByName('new_password')[0].value,
        confirm_password: document.getElementsByName('confirm_password')[0].value
    };

    fetch('controllers/password.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            Swal.fire('Success', 'Password changed successfully!', 'success');
        } else {
            Swal.fire('Error', data.error, 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Something went wrong!', 'error');
    });
});
</script>
</body>
</html>
