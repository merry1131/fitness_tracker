// validation.js
function validateLoginForm() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    if (username === "" || password === "") {
        alert("Please fill out all fields.");
        return false;
    }
    return true;
}
