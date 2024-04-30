<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'header.php';
?>

<div id="questionsDiv">
</div>

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo "<table id='tableQuestions' class='table table-bordered'>";
    echo "<thead><tr><th>Question ID</th><th>User ID</th><th>Question Text</th><th>Question Code</th><th>Active</th><th>Action</th></tr></thead>";
    echo "<tbody></tbody>";
    echo "</table>";
?>
<script>
    document.addEventListener('DOMContentLoaded', fetchQuestions);

    function fetchQuestions() {
        const url = 'controllers/getQuestions.php';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const questionsContainer = document.getElementById('tableQuestions').querySelector('tbody');
                data.forEach(question => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${question.question_id}</td>
                        <td>${question.user_id}</td>
                        <td>${question.question_text}</td>
                        <td>${question.question_code}</td>
                        <td>${question.active}</td>
                        <td><a href="controllers/changeStatus.php?question_id=${question.question_id}&active=${question.active}">${question.active ? `Deactivate` : `Activate`}</a></td>
                    `;

                    questionsContainer.appendChild(row);
                });

                const dataTable = new DataTable('#tableQuestions', {
                    searchable: true, 
                    paging: true, 
                });
            })
            .catch(error => {
                console.error('Error fetching questions:', error);
            });
    }
</script>

<?php

}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>
</body>
</html>
