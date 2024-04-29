function disablePasswordValidation() {
    var passwordField = document.getElementById('password-field');
    passwordField.removeAttribute('required');
}