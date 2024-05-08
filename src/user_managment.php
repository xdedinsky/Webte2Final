<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'header.php';
require '../../../configFinal.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>

<div class="containerTable">
    <div class="tableHeader">
        <h2 class="text" id="text" localize="admin_text"></h2>
        <h2 class="text" id="userDataTitle" localize="user_text" style="display: none;"></h2>
        <h2 class="text" id="userDataTitle2" style="display: none;"></h2>
        <label for="userFilter" localize="user"></label>
        <select id="userFilter" class="filterselect" onchange="filterTableAdmin()">
            <option value="" localize="all_filter"></option>
            <?php
            $sql_users = "SELECT DISTINCT username FROM Users";
            $stmt_users = $conn->prepare($sql_users);
            $stmt_users->execute();
            $result = $stmt_users->get_result();
            while ($user = $result->fetch_assoc()) {
                ?>
                <option value="<?php echo htmlspecialchars($user['username']); ?>">
                    <?php echo htmlspecialchars($user['username']); ?>
                </option>
                <?php
            }
            $stmt_users->close();
            ?>
        </select>
    </div>
</div>
<div class="container mt-4" id="EditName" style="display: none;">
    <h2>Edit Data</h2>
    <form id="editUserDataForm" onsubmit="updateUserData(); return false;">
        <input type="hidden" id="userId" name="user_id" required>
        <div class="mb-3">
            <label for="editUsername" class="form-label">Name:</label>
            <input type="text" class="form-control" id="editUsername" name="username" required>
        </div>
        <div class="mb-3">
            <label for="editEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
        </div>
        <div class="mb-3">
            <label for="editRole" class="form-label">Role:</label>
            <select class="form-select" id="editRole" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
</div>
<div class="container mt-4" id="EditPassword" style="display: none;">
    <h2>Change Password</h2>
    <form id="changePasswordFormAdmin" onsubmit="updatePassword(); return false;">
        <input type="hidden" id="passwordUserId" name="user_id" required>
        <div class="mb-3">
            <label>
                <h2 localize="new_pwd"></h2>
            </label>
            <input type="password" id="password_Admin" name="new_password_Admin" class="form-control" required>
            <div class="invalid-feedback" localize="enter_new_pwd"></div>
        </div>
        <div class="mb-3">
            <label>
                <h2 localize="conf_pwd"></h2>
            </label>
            <input type="password" id="new_password_Admin" name="password_Admin" class="form-control" required>
            <div class="invalid-feedback" localize="confirm_your_pwd"></div>
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </form>
</div>
<script>


    function filterTableAdmin() {
        var selectedUser = document.getElementById("userFilter").value;
        if (selectedUser !== "") {
            document.getElementById("EditName").style.display = "block";
            document.getElementById("EditPassword").style.display = "block";

            document.getElementById("text").style.display = "none";
            document.getElementById("userDataTitle").style.display = "block";
            document.getElementById("userDataTitle2").style.display = "block";
            fetchUserData(selectedUser);
            document.getElementById("userDataTitle2").textContent = selectedUser;
        } else {
            document.getElementById("text").style.display = "block";

            document.getElementById("EditName").style.display = "none";
            document.getElementById("EditPassword").style.display = "none";

            document.getElementById("userDataTitle").style.display = "none"; // Skrýt nový nadpis
            document.getElementById("userDataTitle2").style.display = "none"; // Skrýt nový nadpis

        }

    }
    function fetchUserData(username) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var userData = JSON.parse(xhr.responseText);
                    displayUserData(userData);
                } else {
                    console.error('Error fetching user data:', xhr.status);
                }
            }
        };
        xhr.open('GET', 'fetchUserData.php?username=' + username, false);
        xhr.send();
    }

    function updateUserData() {
        var formData = new FormData(document.getElementById("editUserDataForm"));
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('User data updated successfully');
                    Swal.fire({
                        title: 'Success',
                        text: 'Data updated successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Navigate to user_managment.php
                            window.location.href = "user_managment.php";
                        }
                    });
                } else {
                    console.error('Error updating user data:', xhr.status);
                    // Handle error, show error message, etc.
                }
            }
        };
        xhr.open('POST', './controllers/updateUserData.php', true);
        xhr.send(formData);
    }
    function updatePassword() {
        var formData = new FormData(document.getElementById("changePasswordFormAdmin"));
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Password updated successfully');
                    Swal.fire({
                        title: 'Success',
                        text: 'Data updated successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "user_managment.php";
                        }
                    });
                } else {
                    console.error('Error updating user data:', xhr.status);
                    // Handle error, show error message, etc.
                }
            }
        };
        xhr.open('POST', './controllers/updateUserData.php', true);
        xhr.send(formData);
    }


    function displayUserData(userData) {
        document.getElementById("userId").value = userData.user_id;
        document.getElementById("passwordUserId").value = userData.user_id;

        document.getElementById("editUsername").value = userData.username;
        document.getElementById("editEmail").value = userData.email;
        document.getElementById("editRole").value = userData.role;
        console.log(userData);
    }

</script>