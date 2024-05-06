<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'header.php';

$question_id = $_GET['qid'];

?>

<style>
        #tablesContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Umiestnenie tabuliek v rámci kontajnera */
        }
        table {
            
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        h1 {
            text-align: center;
        }
        .table-caption {
            caption-side: top;
            font-weight: bold;
            font-size: 1.2em;
            padding: 8px;
            background-color: lightgray;
        }
    </style>

<div id="statistics" >
    <h1 id="questionText"></h1>
    <div id="currentTable"></div>

    <div id="backupTables"></div>
    <div id="tablesContainer"></div>

</div>




<script>

    document.addEventListener('DOMContentLoaded', () => {
        const questionId = <?php echo json_encode($question_id); ?>;


        fetch(`controllers/getBackups.php?qid=${questionId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                document.getElementById("questionText").innerHTML = data.question_text;

                let tablesContainer = document.getElementById("tablesContainer");

                for (let col in data.data) {
                    console.log(col);

                    const table = document.createElement('table');
                    table.innerHTML = `<caption style="caption-side: top">${col}</caption>`;

                    // Create table header
                    const headerRow = table.insertRow();
                    const th1 = document.createElement('th');
                    th1.textContent = 'Odpoveď';
                    headerRow.appendChild(th1);
                    const th2 = document.createElement('th');
                    th2.textContent = 'Počet';
                    headerRow.appendChild(th2);
                    const th3 = document.createElement('th');
                    th3.textContent = '%';
                    headerRow.appendChild(th3);

                    const dataList = data.data[col];
                    const dataListKeys = Object.keys(dataList);
                    let allCount = 0;
                    dataListKeys.forEach(key => {
                        allCount+= dataList[key];
                    });
                    

                    dataListKeys.forEach(key => {
                        const count = dataList[key];
                        const row = table.insertRow();
                        const cell1 = row.insertCell();
                        cell1.textContent = key;
                        const cell2 = row.insertCell();
                        cell2.textContent = count;
                        const cell3 = row.insertCell();
                        cell3.textContent = (count/allCount*100).toFixed(2);

                    });

                    // Append table to container
                    tablesContainer.appendChild(table);

                }


            })
            .catch(error => {
                console.error('Error fetching or processing data:', error);
            });

    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>