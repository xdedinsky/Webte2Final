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
// Overenie, či je používateľ prihlásený (session logedin true)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {    

?>
<script>
    fetchQuestions();
function fetchQuestions() {
    // URL pre skript getQuestions.php (upravte podľa potreby)
    const url = 'controllers/getQuestions.php';

    fetch(url)
        .then(response => response.json())
        .then(data => {
            // Získanie kontajneru pre otázky z DOM
            const questionsContainer = document.getElementById('questionsDiv');

            // Iterovanie cez každú otázku v JSON odpovedi
            data.forEach(question => {
                // Vytvorenie elementu pre otázku
                const questionElement = document.createElement('div');
                questionElement.classList.add('question');

                // Naplnenie obsahu otázky s údajmi z JSON
                questionElement.innerHTML = `
                    <p>Question ID: ${question.question_id}</p>
                    <p>User ID: ${question.user_id}</p>
                    <p>Question Text: ${question.question_text}</p>
                    <p>Question Code: ${question.question_code}</p>
                    <p>Updated At: ${question.updated_at}</p>
                `;

                // Pridanie otázky do kontajneru
                questionsContainer.appendChild(questionElement);
            });
        })
        .catch(error => {
            console.error('Error fetching questions:', error);
        });
}
</script>

<?php
// Overenie, či je používateľ prihlásený (session logedin true)
  
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>
</body>
</html>
