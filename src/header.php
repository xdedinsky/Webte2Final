
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
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="select-language">
                <button class="language-btn" data-lang="en" id="en" onclick="setLanguagePreference('en')"><img src="images/uk.png" width="70px" height="50px"></button>
                <button class="language-btn" data-lang="sk" id="sk" onclick="setLanguagePreference('sk')"><img src="images/slovakia.png" width="100px" height="100px"></button>
                </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                <form class="d-flex" action="questionDetail.php" method="get">
                <input class="form-control me-2" type="search" placeholder="Search Q" aria-label="Search" name="questionCode">
                <button class="btn btn-outline-light" localize="search" type="submit"></button>
            </form>
                    <a class="nav-link" localize="home" aria-current="page" href="index.php"></a>
                    <a class="nav-link active" aria-current="page" localize="add_q" href="addQuestion.php"></a>
                    <a class="nav-link" localize="to_be_added" href="addQuestion.php"></a>
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION["username"]); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" localize="acc_settings" href="account_settings.php"></a></li>
                                <li><a class="dropdown-item" localize="log_out" href="controllers/logout.php"></a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Login Modal Trigger -->
                        <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" localize="log_in" data-bs-target="#loginModal"></button>
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
                <h5 class="modal-title" localize="account_acces" id="loginModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs for login and registration forms -->
                <ul class="nav nav-tabs" id="accountTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active zero-border" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" localize="log_in_button" role="tab" aria-controls="login" aria-selected="true"></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link zero-border" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" localize="signup_button" aria-controls="register" aria-selected="false"></button>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" id="accountTabsContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <!-- Login Form -->
                        <form action="controllers/login.php" method="post">
                            <div class="mb-3">
                                <label for="username" localize="username" class="form-label"></label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" localize="pwd" class="form-label"></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" localize="log_in_button" class="btn btn-primary"></button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <!-- Registration Form -->
                        <form action="controllers/register.php" method="post" onsubmit="return validatePassword();">
                            <div class="mb-3">
                                <label for="username" localize="username" class="form-label"></label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" localize="email" class="form-label"></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" localize="pwd" class="form-label"></label>
                                <input type="password" class="form-control" id="passwordReg" name="passwordReg" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" localize="confirm_pwd" class="form-label"></label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" localize="signup_button" class="btn btn-primary"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
 



    