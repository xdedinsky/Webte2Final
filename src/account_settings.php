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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container mt-4">
        <h2 localize="change_pwd"></h2>
        <form action="" id="changePasswordForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <label>
                    <h2 localize="current_pwd"></h2>
                </label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
                <div class="invalid-feedback" localize="enter_current_pwd"></div>
            </div>
            <div class="mb-3">
                <label>
                    <h2 localize="new_pwd"></h2>
                </label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
                <div class="invalid-feedback" localize="enter_new_pwd"></div>
            </div>
            <div class="mb-3">
                <label>
                    <h2 localize="conf_pwd"></h2>
                </label>
                <input type="password" id="confirm_password2" name="confirm_password2" class="form-control" required>
                <div class="invalid-feedback" localize="confirm_your_pwd"></div>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="alerts.js"></script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function () {
            $('#changePasswordForm').submit(function (event) {
                event.preventDefault();
                if (this.checkValidity()) {
                    var formData = {
                        confirm_password2: $('#confirm_password2').val(),
                        current_password: $('#current_password').val(),
                        new_password: $('#new_password').val(),
                    };

                    $.ajax({
                        type: 'POST',
                        url: 'controllers/password.php',
                        data: JSON.stringify(formData),
                        contentType: 'application/json',
                        success: function (data) {
                            if (data.success) {
                                Swal.fire('Success', 'Password changed successfully!', 'success').then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'https://node71.webte.fei.stuba.sk/Webte2Final/src/account_settings.php';
                                    }
                                });
                            } else {
                                Swal.fire('Error', data.error, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                        }
                    });
                } else {
                    event.stopPropagation();
                }
                $('#changePasswordForm').addClass('was-validated');
            });
        });
    </script>
</body>

</html>