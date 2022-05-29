function validateLogin(e) {
    if( login.user.value.length == 0 || login.password.value.length == 0)
    {
        alert("Compilare tutti i campi!");
        e.preventDefault();
    }
}

const login = document.forms['login-form'];
login.addEventListener('submit', validateLogin);