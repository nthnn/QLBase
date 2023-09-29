function isStrongPassword(password) {
    return password.length > 8 &&
        /[A-Z]/.test(password) &&
        /[a-z]/.test(password) &&
        /\d/.test(password) &&
        /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/.test(password);
}