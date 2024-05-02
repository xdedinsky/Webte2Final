<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'header.php';
require '../../../configFinal.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $stmt = $conn->prepare("SELECT role FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();
    $user_id = $_SESSION["user_id"];
    ?>
    <div class="containerTable">
        <div class="tableHeader">
            <?php if ($role === "admin") { ?>
                <label for="userFilter" localize="user"></label>
                <select id="userFilter" class="filterselect" onchange="filterTableAdmin()">
                    <option value="" localize="all_filter"></option>

                    <?php
                    // Check the role to determine the SQL query and bind parameters
            
                    $sql_users = "SELECT DISTINCT username FROM Users";
                    $stmt_users = $conn->prepare($sql_users);
                    // Execute the prepared statement
                    $stmt_users->execute();

                    // Get the result set
                    $result = $stmt_users->get_result();

                    // Loop through unique user names and generate <option> elements
                    while ($user = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo htmlspecialchars($user['username']); ?>">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </option>
                        <?php
                    }

                    // Close the statement
                    $stmt_users->close();
                    ?>

                </select>

                <?php
            }
} ?>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="alerts.js"></script>
    <script src="script.js"></script>