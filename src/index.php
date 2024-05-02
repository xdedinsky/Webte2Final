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
            <label for="subjectFilter" localize="subject"></label>
            <select id="subjectFilter" class="filterselect" onchange="filterTable()">
                <option value="" localize="all_filter"></option>
                <?php
                if ($role === "admin") {
                    $sql_questions = "SELECT DISTINCT subject  FROM Questions";
                    $stmt_questions = $conn->prepare($sql_questions);
                } elseif ($role === "user") {
                    $sql_questions = "SELECT DISTINCT subject  FROM Questions WHERE user_id = ?";
                    $stmt_questions = $conn->prepare($sql_questions);
                    $stmt_questions->bind_param("i", $user_id);
                }
                $stmt_questions->execute();
                $result = $stmt_questions->get_result();
                foreach ($result as $row): ?>
                    <option value="<?php echo $row['subject'] ?>">
                        <?php echo $row['subject'] ?>
                    </option>
                <?php endforeach; ?>
                <!-- Add years dynamically based on your data -->
            </select>

            <label for="dateFilter" localize="date"></label>
            <select id="dateFilter" class="filterselect" onchange="filterTable()">
                <option value="" localize="all"></option>
                <?php
                if ($role === "admin") {
                    $sql_dates = "SELECT DISTINCT DATE(created_at) AS date_value FROM Questions";
                    $stmt_dates = $conn->prepare($sql_dates);
                } elseif ($role === "user") {
                    $sql_dates = "SELECT DISTINCT DATE(created_at) AS date_value FROM Questions WHERE user_id = ?";
                    $stmt_dates = $conn->prepare($sql_dates);
                    $stmt_dates->bind_param("i", $user_id);
                }
                // Query to fetch unique dates from the Questions table
            
                $stmt_dates->execute();
                $dates = $stmt_dates->get_result();


                // Loop through unique dates and generate <option> elements
                foreach ($dates as $date): ?>
                    <option value="<?php echo htmlspecialchars($date['date_value']); ?>">
                        <?php echo htmlspecialchars($date['date_value']); ?>
                    </option>

                <?php endforeach; ?>



            </select>

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


    <div id="questionsDiv">
    </div>
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="qrCode" style="text-align: center;"></div> <!-- Inline style for centering -->
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="alerts.js"></script>
    <script src="script.js"></script>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo "<table id='tableQuestions' class='table table-bordered'>";
        echo "<thead><tr><th>Question ID</th><th>User</th><th>Subject</th><th>Question Text</th><th>Question Code</th><th>Date</th><th>Active</th><th>QR Code</th></tr></thead>";
        echo "<tbody></tbody>";
        echo "</table>";
        ?>

        <script>
            function showQRCode(questionCode) {
                var qrCodeContainer = document.getElementById('qrCode');
                qrCodeContainer.innerHTML = ''; // Clear previous QR codes

                // Create an anchor element that wraps the QR code and redirects on click
                var link = document.createElement('a');
                link.href = `https://node28.webte.fei.stuba.sk/${questionCode}`; // Link to redirect
                link.target = '_blank'; // Open in new tab

                // Create QR code inside the link
                var qr = new QRCode(link, {
                    text: `https://node28.webte.fei.stuba.sk/${questionCode}`,
                    width: 256,
                    height: 256,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });

                qrCodeContainer.appendChild(link); // Append the link (which contains the QR code) to the modal body
            }

            let dataTable;
            function filterTable() {
                const subject = document.getElementById('subjectFilter').value;
                const date = document.getElementById('dateFilter').value;
                if (subject == '') {
                    dataTable.column('#scol').search('').draw();
                } else {
                    dataTable.column('#scol').search(subject).draw();
                }
                if (date == '') {
                    dataTable.column('#dcol').search('').draw();
                } else {
                    dataTable.column('#dcol').search(date).draw();
                }
            }

            function filterTableAdmin() {
                const user = document.getElementById('userFilter').value;
                if (user == '') {
                    dataTable.column('#ucol').search('').draw();
                } else {
                    dataTable.column('#ucol').search(user).draw();
                }
                filterTable();
            }
            document.addEventListener('DOMContentLoaded', fetchQuestions);

            function fetchQuestions() {
                const url = 'controllers/getQuestions.php';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const questionsContainer = document.getElementById('tableQuestions').querySelector('tbody');
                        data.forEach(question => {
                            const row = document.createElement('tr');

                            // Check if the question is active and set the checkbox accordingly
                            const isChecked = question.active == '1' ? 'checked' : '';
                            const username2 = question.username;
                            row.innerHTML = `
                                                <td>${question.question_id}</td>
                                                <td>${question.username}</td>
                                                <td>${question.subject}</td>
                                                <td>${question.question_text}</td>
                                                <td>${question.question_code}</td>
                                                <td>${question.date}</td>
                                                <td>   
                                                    <input type="checkbox" ${isChecked} onchange="toggleActive(${question.question_id}, this.checked)">
                                                </td>
                                                    <td class="center-content">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#qrModal" onclick="showQRCode('${question.question_code}')">
                                                            <img src="images/qrimage.png" alt="qrimage" width="20" height="20">
                                                        </a>
                                                    </td>
                                                `;

                            questionsContainer.appendChild(row);
                        });

                        dataTable = new DataTable('#tableQuestions', {
                            searchable: true,
                            paging: true,
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching questions:', error);
                    });
            }

            function toggleActive(questionId, isActive) {
                // Create the URL to send the request to
                const url = `controllers / changeStatus.php ? question_id = ${questionId} & active=${isActive ? 1 : 0}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.success ? 'success' : 'error',
                            title: data.success ? 'Success' : 'Error',
                            text: data.message
                        });
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                    });
            }

        </script>

        <?php

    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>

    </body>

    </html>