<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'header.php';

$question_id = $_GET['qid'];
?>



<div id="answers">
<h2 localize="results"></h2>
</div>


<div id="wordCloud">

</div>
<script>
// JavaScript kód s použitím PHP premennej questionId
const question_id = <?php echo json_encode($question_id); ?>;

// Overenie, či je questionId definované a nie je null
if (question_id) {
    const url = `controllers/showAnswers.php?qid=${question_id}`;

    // Použitie fetch pre získanie dát zo zadaného URL
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Výpis JSON dát do konzoly
            // Príklad: Manipulácia s JSON dátami, aktualizácia UI atď.
            let answersContainer =document.getElementById("answers");
            const questionTextHeading = document.createElement("h3");
            questionTextHeading.textContent = data.question_text;
            answersContainer.appendChild(questionTextHeading);

            // Zobrazenie údajov vo forme nečíslovaného zoznamu
            const dataList = data.data;
            const dataListKeys = Object.keys(dataList);

            const dataListContainer = document.createElement("ul");
            dataListKeys.forEach(key => {
                const listItem = document.createElement("li");
                const count = dataList[key];
                const displayText = count > 1 ? `${key} (${count}x)` : key;
                listItem.textContent = displayText;
                dataListContainer.appendChild(listItem);
            });

            answersContainer.appendChild(dataListContainer);


            createWordCloud(data); 
        })
        .catch(error => {
            console.error('Fetch error:', error);
            // Handle errors, e.g., display an error message to the user
        });
} else {
    console.error('Question ID is not defined or null.');
    // Handle case when questionId is not defined or null
}






function createWordCloud(data) {
    const wordCloudContainer = document.getElementById('wordCloud'); // Získanie kontajnera pre word cloud

    // Vytvorenie elementov pre zobrazenie jednotlivých slov v word cloude
    Object.entries(data.data).forEach(([word, count]) => {
        const wordElement = document.createElement('span');
        wordElement.textContent = `${word} `; // Zobrazenie slova s medzerou

        // Zmena veľkosti písma podľa počtu výskytov
        wordElement.style.fontSize = `${count * 15}px`;

        wordCloudContainer.appendChild(wordElement); // Pridanie slova do word cloudu
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="alerts.js"></script>
<script src="script.js"></script>

