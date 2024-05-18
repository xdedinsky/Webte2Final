<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "header.php";
?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title localize="title"></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #skmanual,
        #enmanual {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .pManual {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .iconManual {
            vertical-align: middle;
            margin-right: 5px;
        }

        @media (min-width: 768px) {
    .col-md-6 {
        flex: 0 0 auto;
    }
}
    </style>
</head>

<body>


    <div id="content" class="container">
        <div class="col">
            <div  class="mt-3">
                <div class="card" id="manual">
                    <div class="card-body">
                        <button id="downloadButton" onclick="generatePDF()" localize="download_info"></button>
                        <h1 class="card-title" localize="manual_info"></h1>
                        <p class="card-text" localize="pdf"></p>
                        <p class="pManual">
                            <img src="images/backup.png" alt="backup" width="20" height="20" class="iconManual">
                            <span localize="back_up"></span>
                        </p>
                        <p class="pManual">
                            <img src="images/bin.png" alt="bin" width="20" height="20" class="iconManual">
                            <span localize="delete_q"></span>
                        </p>
                        <p class="pManual">
                            <img src="images/copy.png" alt="copy" width="20" height="20" class="iconManual">
                            <span localize="copy_q"></span>
                        </p>
                        <p class="pManual">
                            <img src="images/edit.png" alt="edit" width="20" height="20" class="iconManual">
                            <span localize="update_q"></span>
                        </p>
                        <p class="pManual">
                            <img src="images/eye.png" alt="eye" width="20" height="20" class="iconManual">
                            <span localize="eye_q"></span>
                        </p>
                        <p class="pManual">
                            <img src="images/qrimage.png" alt="qrimage" width="20" height="20" class="iconManual">
                            <span localize="qrimage_q"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <div class="user mt-3">
                    <div class="title_user">
                        <h1 localize="manual_info"></h1>
                    </div>
                    <h2 localize="login"></h2>
                    <ul>
                        <li localize="text_1"></li>
                    </ul>

                    <h2 localize="change_pwd_i"></h2>
                    <ul>
                        <li localize="text_2"></li>
                    </ul>

                    <h2 localize="vote_i"></h2>
                    <h5 localize="text_3_i"></h5>
                    <ul>
                        <li localize="text_4_i"></li>
                        <li localize="text_5_i"></li>
                        <li localize="text_6_i"></li>
                    </ul>

                    <h2 localize="text_7_i"></h2>
                    <ul>
                        <li localize="text_8_i"></li>
                        <li localize="text_9_i"></li>
                    </ul>

                    <h2 localize="text_10_i"></h2>
                    <ul>
                        <li localize="text_11_i"></li>
                    </ul>

                    <h2 localize="text_12_i"></h2>
                    <ul>
                        <li localize="text_13_i"></li>
                    </ul>

                    <h2 localize="text_14_i"></h2>
                    <ul>
                        <li localize="text_15_i"></li>
                    </ul>

                    <h2 localize="text_16_i"></h2>
                    <ul>
                        <li localize="text_17_i"></li>
                    </ul>

                    <h2 localize="text_18_i"></h2>
                    <ul>
                        <li localize="text_19_i"></li>
                    </ul>

                    <h2 localize="text_20_i"></h2>
                    <ul>
                        <li localize="text_21_i"></li>
                    </ul>

                    <h2 localize="text_22_i"></h2>
                    <ul>
                        <li localize="text_23_i"></li>
                    </ul>

                    <h2 localize="text_24_i"></h2>
                    <ul>
                        <li localize="text_25_i"></li>
                    </ul>
                </div>
                <div class="admin_text mt-3">
                    <h1 localize="text_26_i"></h1>
                    <ol>
                        <li localize="text_27_i"></li>
                        <li localize="text_28_i"></li>
                        <li localize="text_29_i"></li>
                    </ol>
                </div>
                <div class="mt-3">
                    <h2 localize="text_30_i"></h2>
                    <ul>
                        <li localize="text_31_i"></li>
                        <ul>
                            <li localize="text_32_i"></li>
                            <li localize="text_33_i"></li>
                            <li localize="text_34_i"></li>
                        </ul>
                    </ul>
                </div>
                <div class="col">
                    <h2 localize="text_35_i"></h2>
                    <ul>
                        <li localize="text_36_i"></li>
                        <li localize="text_37_i"></li>
                    </ul>
                </div>
                <div class="col">
                    <h2 localize="text_38_i"></h2>
                    <ul>
                        <li localize="text_39_i"></li>
                        <li localize="text_40_i"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <!-- Bootstrap JS and other libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script>
        let lang = localStorage.getItem('language')
        function generatePDF() {
            // Získať obsah celej stránky na tlač
            const element = document.getElementById('content');

            // Nastavenie možností pre generovanie PDF
            const options = {
                margin: 1,
                filename: 'manual.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // Použitie html2pdf knižnice na generovanie PDF
            html2pdf().set(options).from(element).save();
        }
    </script>
</body>

</html>