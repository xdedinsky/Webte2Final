<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    .hidden {
        display: none;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="images/vote.png" alt="Vote System Logo">
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link active" aria-current="page" href="addQuestion.php">Add Q</a>
                    <a class="nav-link" href="tobeadded.php">ToBeAdded</a>
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION["username"]); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="account_settings.php">Account Settings</a></li>
                                <li><a class="dropdown-item" href="controllers/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Login Modal Trigger -->
                        <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">Log
                            In</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login/Register Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Account Access</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Nav tabs for login and registration forms -->
                    <ul class="nav nav-tabs" id="accountTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active zero-border" id="login-tab" data-bs-toggle="tab"
                                data-bs-target="#login" type="button" role="tab" aria-controls="login"
                                aria-selected="true">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link zero-border" id="register-tab" data-bs-toggle="tab"
                                data-bs-target="#register" type="button" role="tab" aria-controls="register"
                                aria-selected="false">Register</button>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content" id="accountTabsContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <!-- Login Form -->
                            <form action="controllers/login.php" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <!-- Registration Form -->
                            <form action="controllers/register.php" method="post" onsubmit="return validatePassword();">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="passwordReg" name="passwordReg"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <form id="questionForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="question_type" class="form-label">
                    <h2>Select Question Type:</h2>
                </label>
                <select id="question_type" name="question_type" class="form-select" required>
                    <option value="open_ended" style="user-select: none;">Open Question</option>
                    <option value="multiple_choice">Question with Options</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type_of_question" class="form-label">
                    <h2>Type of Question:</h2>
                </label>
                <input type="text" id="type_of_question" name="type_of_question" class="form-control"
                    required placeholder="Write the type of question">
            </div>

            <div class="mb-3">
                <label for="question_text" class="form-label">
                    <h2>Question Text:</h2>
                </label>
                <input type="text" id="question_text" name="question_text" class="form-control" required>
            </div>

            <div id="optionsContainer" class="hidden">
                <div class="mb-3">
                    <label class="form-label">
                        <h2>Answer Type:</h2>
                    </label>
                    <div>
                        <input type="radio" id="single_answer" name="answer_type" value="single" checked required>
                        <label for="single_answer">Single Correct Answer</label>
                    </div>
                    <div>
                        <input type="radio" id="multiple_answers" name="answer_type" value="multiple" required>
                        <label for="multiple_answers">Multiple Correct Answers</label>
                    </div>
                </div>

                <label>
                    <h2>Options:</h2>
                </label>
                <div id="optionFields">
                    <input type="text" name="options[]" class="form-control" placeholder="Option 1">
                    <input type="text" name="options[]" class="form-control" placeholder="Option 2">
                </div>
                <div class="centered">
                    <button type="button" id="addOption" class="btn btn-custom">Add Option</button>
                    <button type="button" id="deleteOption" class="btn btn-custom">Delete Option</button>
                </div>
            </div>

            <div class="centered">
                <button type="submit" id="submitButton" class="btn btn-custom">Submit Question</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="alerts.js"></script>

    <script>
        $(document).ready(function () {
            $('#question_type').change(function () {
                const type = $(this).val();
                if (type === 'multiple_choice') {
                    $('#optionsContainer').removeClass('hidden');
                    $('input[name="options[]"]').attr('required', true);  // Make options required when visible
                    $('input[name="answer_type"]').attr('required', true);
                    $('input[name="type_of_question"]').attr('required', true);

                } else {
                    $('#optionsContainer').addClass('hidden');
                    $('input[name="options[]"]').removeAttr('required');  // Remove required attribute when not visible
                    $('input[name="answer_type"]').removeAttr('required');
                    $('input[name="type_of_question"]').removeAttr('required');

                }
            });

            $('#addOption').click(function (event) {
                event.preventDefault();
                const optionNumber = $('#optionFields input').length + 1;
                const newOption = `<input type="text" name="options[]" class="form-control" placeholder="Option ${optionNumber}" required>`;  // Add required attribute
                $('#optionFields').append(newOption);
            });

            $('#deleteOption').click(function (event) {
                event.preventDefault();
                let options = $('#optionFields input');
                if (options.length > 2) {
                    options.last().remove();
                } else {
                    Swal.fire({
                        title: 'Attention!',
                        text: 'You must keep at least two options.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $('#questionForm').submit(function (event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
                    const formData = {
                        question_text: $('#question_text').val(),
                        question_type: $('#question_type').val(),
                        type_of_question: $('#type_of_question').val(),
                            options: $('#question_type').val() === 'multiple_choice' ? $('input[name="options[]"]').map(function () { return $(this).val(); }).get() : [],
                        answer_type: $('#question_type').val() === 'multiple_choice' ? $('input[name="answer_type"]:checked').val() : null
                    };

                    $.ajax({
                        type: "POST",
                        url: "controllers/question.php",
                        data: JSON.stringify(formData),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function (response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Question submitted successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function (err) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Error submitting question!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
                this.classList.add('was-validated');
            });
        });

    </script>
    <script src="script.js"></script>
</body>

</html>