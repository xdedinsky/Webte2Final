function updateContent(langData) {
    document.querySelectorAll('[localize]').forEach(element => {
        const key = element.getAttribute('localize');
        element.textContent = langData[key];
    });
}

function setLanguagePreference(lang) {
    localStorage.setItem('language', lang);
    location.reload();
}

async function fetchLanguageData(lang) {
    const response = await fetch(`language/${lang}.json`);
    return response.json();
}

async function changeLanguage(lang) {
    await setLanguagePreference(lang);

    const langData = await fetchLanguageData(lang);
    updateContent(langData);
}

window.addEventListener('DOMContentLoaded', async () => {
    const userPreferredLanguage = localStorage.getItem('language') || 'en';
    const langData = await fetchLanguageData(userPreferredLanguage);
    updateContent(langData);

});

function validatePassword() {
    var password = document.getElementById("passwordReg").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var email = document.getElementById("email").value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (password.trim() === '' || confirm_password.trim() === '') {
        console.log("ASDs");
        Swal.fire({
            title: 'Empty Password Field!',
            text: 'Please fill in the password field.',
            icon: 'error',
            background: '#FFFFFF',
            color: '#000000',
            confirmButtonColor: '#FF6A00',
            confirmButtonText: 'Ok'
        });
        return false; // Prevent form submission
    }

    if (password.length < 2 || confirm_password.length < 2) {
        console.log("ASDs");
        Swal.fire({
            title: 'Weak Password!',
            text: 'Password must be at least 2 characters long.',
            icon: 'error',
            background: '#FFFFFF',
            color: '#000000',
            confirmButtonColor: '#FF6A00',
            confirmButtonText: 'Ok'
        });
        return false; // Prevent form submission
    }
    if (password.length < 6 || confirm_password.length < 6) {
        Swal.fire({
            title: 'Weakss Password!',
            text: 'Your password must be at least 6 characters long.',
            icon: 'error',
            background: '#FFFFFF',
            color: '#000000',
            confirmButtonColor: '#FF6A00',
            confirmButtonText: 'Ok'
        });
        return false; // Prevent form submission
    }
    if (password !== confirm_password) {
        Swal.fire({
            title: 'Password Mismatch!',
            text: 'Please make sure your passwords match.',
            icon: 'error',
            background: '#FFFFFF',
            color: '#000000',
            confirmButtonColor: '#FF6A00',
            confirmButtonText: 'Ok'
        });
        return false; // Prevent form submission
    }

    // Check if email format is valid using JavaScript regex
    if (!emailRegex.test(email)) {
        console.log("ASD");
        Swal.fire({
            title: 'Invalid Email!',
            text: 'Please enter a valid email address.',
            icon: 'error',
            background: '#FFFFFF',
            color: '#000000',
            confirmButtonColor: '#FF6A00',
            confirmButtonText: 'Ok'
        });
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}




function fetchQuestions() {
    console.log("som v metode");
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