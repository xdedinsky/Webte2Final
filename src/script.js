function validatePassword() {
    var password = document.getElementById("passwordReg");
    var confirm_password = document.getElementById("confirm_password");
    if (password.length < 6) {
        Swal.fire({
            title: 'Weak Password!',
            text: 'Your password must be at least 6 characters long.',
            icon: 'error',
            background: '#FFFFFF',
            color: '#000000',
            confirmButtonColor: '#FF6A00',
            confirmButtonText: 'Ok'
        });
        return false; // Prevent form submission
    }

    if (password.value !== confirm_password.value) {
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
    return true; // Allow form submission
}