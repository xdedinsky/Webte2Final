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

    echo"som dnu";
    echo '<script>';
    echo 'fetchQuestions();'; // Volanie funkcie fetchQuestions() v JavaScripte
    echo '</script>';
}
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>
</body>
</html>
