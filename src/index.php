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
    $user_id = $_SESSION["user_id"] ;
?>
<div class="containerTable">
    <div class="tableHeader">
        <label for="subjectFilter">Subject:</label>
        <select id="subjectFilter" class="filterselect" onchange="filterTable()">
            <option value="">Všetky</option>
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

        <label for="dateFilter">Date:</label>
        <select id="dateFilter" class="filterselect" onchange="filterTable()">
            <option value="">All</option>
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

        <?php if($role==="admin"){?>
        <label for="userFilter">User:</label>
        <select id="userFilter" class="filterselect" onchange="filterTableAdmin()">
            <option value="">All</option>

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
        }?>
    </div>


    <div id="questionsDiv">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo "<table id='tableQuestions' class='table table-bordered'>";
    echo "<thead><tr><th>Question ID</th><th id = 'ucol'>User</th><th id = 'scol'>Subject</th><th>Question Text</th><th>Question Code</th><th id = 'dcol'>Date</th><th>Active</th></tr></thead>";
    echo "<tbody></tbody>";
    echo "</table>";
?>

<script>
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
        const url = `controllers/changeStatus.php?question_id=${questionId}&active=${isActive ? 1 : 0}`;
        
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
</body>
</html>
