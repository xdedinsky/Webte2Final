<?php
include "header.php";
?>
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
</style>




<button id="downloadButton" onclick="generatePDF()">Stiahnuť príručku vo formáte PDF</button>
<div id="content">
    <div id="skmanual" style="display: none">
        <h1 class="manual-title">Slovenská príručka</h1>
        <p class="manual-text">Toto je slovenský manuál vo formáte PDF s diakritikou.</p>
        <p class="pManual"><img src="images/bin.png" alt="bin" width="20" height="20" class="iconManual"> Kliknutím na
            ikonu koša vymažete danú
            otázku.</p>
        <p class="pManual"><img src="images/edit.png" alt="edit" width="20" height="20" class="iconManual"> Kliknutím na
            ikonu úpravy môžete
            upraviť danú otázku.</p>
    </div>

    <div id="enmanual" style="display: none">
        <h1 class="manual-title">English Manual</h1>
        <p class="manual-text">This is an English manual in PDF format.</p>
    </div>


</div>


<!-- Odkazy na knižnice html2pdf.js a jspdf -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let lang = localStorage.getItem('language');
        console.log(lang);
        if(lang === "sk"){
            document.getElementById("skmanual").style.display = "block";
            document.getElementById("enmanual").style.display = "none";
        }else if(lang === "en"){
            document.getElementById("enmanual").style.display = "block";
            document.getElementById("skmanual").style.display = "none";
        }

    });
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