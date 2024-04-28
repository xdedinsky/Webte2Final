<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../../configFinal.php'; 

$questionCode = $_GET['questionCode'] ?? '';  // Safely fetch the question code

// Prepare and execute the query to fetch the question details
if ($stmt = $conn->prepare("SELECT * FROM Questions WHERE question_code = ?")) {
    $stmt->bind_param("s", $questionCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if a question was actually fetched
    if ($question = $result->fetch_assoc()) {
        // Check the type of question and fetch options if it's multiple choice
        if ($question['question_type'] == 'multiple_choice') {
            if ($optionsStmt = $conn->prepare("SELECT option_id, option_text FROM QuestionOptions WHERE question_id = ?")) {
                $optionsStmt->bind_param("i", $question['question_id']);
                $optionsStmt->execute();
                $optionsResult = $optionsStmt->get_result();
                $options = $optionsResult->fetch_all(MYSQLI_ASSOC);
            }
        }
    } else {
        header("location: /Webte2Final/src/index.php?action=code-not-found");
        exit;
    }
    $stmt->close();
} else {
    echo "SQL Error: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="images/vote.png" alt="Vote System Logo">
            </a>
            <form class="d-flex" action="questionDetail.php" method="get">
                <input class="form-control me-2" type="search" placeholder="Search Q" aria-label="Search" name="questionCode">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link" aria-current="page" href="addQuestion.php">Add Q</a>
                    <a class="nav-link" href="tobeadded.php">ToBeAdded</a>
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION["username"]); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="account_settings.php">Account Settings</a></li>
                                <li><a class="dropdown-item" href="controllers/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Login Modal Trigger -->
                        <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</button>
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
                        <button class="nav-link active zero-border" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link zero-border" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Register</button>
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
                                <input type="password" class="form-control" id="passwordReg" name="passwordReg" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
 
    <div class="row justify-content-center" style="margin-top: 5rem;">
        <div class="col-md-8">
            <form id="answerForm" action="controllers/submitAnswer.php" method="post">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Question Detail</h2>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($question)): ?>
                            <h2 style="text-align:left;">Question:</h2>
                            <p class="card-text"><?php echo htmlspecialchars($question['question_text']); ?></p>

                            <?php if ($question['question_type'] == 'multiple_choice' && !empty($options)): ?>
                                <div class="mt-4">
                                    <h2 style="text-align:left;">Select your answer:</h2>
                                    <?php foreach ($options as $option): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answer" id="option<?php echo htmlspecialchars($option['option_id']); ?>" value="<?php echo htmlspecialchars($option['option_id']); ?>" required>
                                            <label class="form-check-label" for="option<?php echo htmlspecialchars($option['option_id']); ?>">
                                                <?php echo htmlspecialchars($option['option_text']); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="mt-4">
                                    <label for="openAnswer" class="form-label"><h2>Your answer:</h2></label>
                                    <input type="text" class="form-control" id="openAnswer" name="answer" required>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="card-text">No question found with that code.</p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <!-- Hidden input to carry the question ID -->
                        <input type="hidden" name="question_id" value="<?php echo $question['question_id']; ?>">
                        <button type="submit" class="btn btn-primary">Submit Answer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>
<script>
$(document).ready(function() {
    $('#answerForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        var formData = {
            question_id: $("input[name='question_id']").val(),
            answer: $("input[name='answer']:checked, #openAnswer").val()
        };

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: JSON.stringify(formData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(response) {
                console.log('Success:', response);
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
            }
        });
    });
});
</script>

</body>
</html>
