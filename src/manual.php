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
    <title>Manuál pre administrátora</title>
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
                        <h1 class="card-title" localize="sk_info">Manuál pre používateľa</h1>
                        <p class="card-text" localize="pdf"></p>
                        <p class="pManual">
                            <img src="images/backup.png" alt="backup" width="20" height="20" class="iconManual">
                            <span localize="backup_q">Záloha</span>
                        </p>
                        <p class="pManual">
                            <img src="images/bin.png" alt="bin" width="20" height="20" class="iconManual">
                            <span localize="delete_q"></span>
                        </p>
                        <p class="pManual">
                            <img src="images/copy.png" alt="copy" width="20" height="20" class="iconManual">
                            <span localize="edit_q"></span>
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
                        <h1>Manuál pre používateľa</h1>
                    </div>
                    <h2>Prihlásenie:</h2>
                    <ul>
                        <li>Používateľ sa môže prihlásiť pomocou vlastnej registrácie.</li>
                    </ul>

                    <h2>Zmena hesla:</h2>
                    <ul>
                        <li>Používateľ môže zmeniť svoje heslo. Kliknutim na svoje meno v menu a v sekcii
                            Nastavienie
                            účtu</li>
                    </ul>

                    <h2>Hlasovacie otázky:</h2>
                    <h5>Hlasovanie je možne v menu Pridať otázku </h5>
                    <ul>
                        <li>Používateľ môže definovať viacero hlasovacích otázok.</li>
                        <li>Používateľ môže definovať aktívne a neaktívne otázky.</li>
                        <li>Každej otázke je generovaný QR kód a unikátny 5-znakový kód.</li>
                    </ul>

                    <h2>Typy otázok:</h2>
                    <ul>
                        <li>Otázky s výberom správnej odpovede.</li>
                        <li>Otázky s otvorenou krátkou odpoveďou.</li>
                    </ul>

                    <h2>Zobrazenie výsledkov:</h2>
                    <ul>
                        <li>Pri otázkach s otvorenou odpoveďou je možné zobraziť výsledky ako zoznam alebo "word
                            cloud".
                        </li>
                    </ul>

                    <h2>Úprava otázok:</h2>
                    <ul>
                        <li>Používateľ môže upravovať, mazať a kopírovať existujúce otázky.</li>
                    </ul>

                    <h2>Vzťah k predmetom:</h2>
                    <ul>
                        <li>Každej otázke je možné priradiť predmet.</li>
                    </ul>

                    <h2>Filtrovanie otázok:</h2>
                    <ul>
                        <li>Otázky je možné filtrovať podľa predmetu a dátumu vytvorenia.</li>
                    </ul>

                    <h2>Uzatvorenie hlasovania:</h2>
                    <ul>
                        <li>Používateľ môže uzavrieť aktuálne hlasovanie na otázku, čo zahŕňa zazálohovanie odpovedí
                            a
                            pridanie
                            poznámky a dátumu uzatvorenia.</li>
                    </ul>

                    <h2>Zobrazenie výsledkov:</h2>
                    <ul>
                        <li>Možnosť zobraziť výsledky aktuálnych aj archivovaných hlasovaní.</li>
                    </ul>

                    <h2>Porovnanie s historickými hlasovaniami:</h2>
                    <ul>
                        <li>Pri otázkach s výberom správnej odpovede je možné porovnať aktuálne hlasovanie s
                            historickými
                            pomocou tabuľky.</li>
                    </ul>

                    <h2>Export otázok a odpovedí:</h2>
                    <ul>
                        <li>Možnosť exportu otázok a odpovedí do externých súborov (CSV, JSON, XML).</li>
                    </ul>
                </div>
                <div class="admin_text mt-3">
                    <h1>Manuál pre admina</h1>
                    <ol>
                        <li>Administrátor má tú istú funkčnosť ako prihlásený používateľ s tým rozdielom, že má k
                            dispozícii
                            hlasovacie otázky všetkých prihlásených používateľov s možnosťou filtrovania nad
                            vybraným
                            používateľom.
                        </li>
                        <li>
                            Pri vytváraní novej hlasovacej otázky administrátor môže špecifikovať, či to robí
                            vlastným
                            menom alebo v
                            mene iného používateľa.
                        </li>
                        <li>
                            Administrátor má prístup k správe prihlásených používateľov, vrátane vytvárania,
                            čítania,
                            aktualizácie a
                            mazania (CRUD) používateľských účtov, ako aj možnosť zmeny ich rolí a hesiel.
                        </li>
                    </ol>
                </div>
                <div class="mt-3">
                    <h2>Získanie hlasovacej otázky:</h2>
                    <ul>
                        <li>Používateľ sa môže dostať na stránku s hlasovacou otázkou:</li>
                        <ul>
                            <li>Načítaním zverejneného QR kódu.</li>
                            <li>Zadaním vstupného kódu na domovskej stránke aplikácie.</li>
                            <li>Zadaním adresy do prehliadača v tvare `https://nodeXX.webte.fei.stuba.sk/abcde`, kde
                                `abcde` je 5-znakový vstupný kód.</li>
                        </ul>
                    </ul>
                </div>
                <div class="col">
                    <h2>Vyplnenie hlasovacej otázky:</h2>
                    <ul>
                        <li>Po vyplnení hlasovacej otázky bude užívateľ presmerovaný na stránku s grafickým zobrazením
                            výsledkov hlasovania na danú otázku.</li>
                        <li>Na tejto stránke bude možný návrat na domovskú stránku aplikácie.</li>
                    </ul>
                </div>
                <div class="col">
                    <h2>Zobrazenie výsledkov:</h2>
                    <ul>
                        <li>Pri zobrazení výsledkov hlasovania na otvorenú otázku budú odpovede zobrazené buď ako
                            položky nečíslovaného zoznamu alebo pomocou tzv. "word cloud-u".</li>
                        <li>Pri "word cloud-e" bude mať počet rovnakých odpovedí na otázku vplyv na veľkosť písma pri
                            zobrazení tejto odpovede.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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