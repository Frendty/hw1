let userErr = 0;
let emailErr = 0;

function onJson(json)
{
    const wrap = document.querySelector("input[name=" + json.type + "]").parentNode.parentNode;
    const p = wrap.querySelector("p");

    if(json.used && json.type == "user")
    {
        p.textContent = "Username già in uso!";
        p.classList.remove("hidden");
        userErr = 1;
        wrap.appendChild(p);
    }
    else if(json.type != "email")
    {
        p.classList.add("hidden");
        userErr = 0;
    }
    
    if(json.used && json.type == "email")
    {
        p.classList.remove("hidden");
        p.textContent = "Email già in uso!";
        emailErr = 1;
        wrap.appendChild(p);
    }
    else if (json.type != "user")
    {
        p.classList.add("hidden");
        emailErr = 0;
    }
}

function onResponse(response) {
    return response.json();
}

function checkFieldTaken(e) {
    const field = e.currentTarget;
    fetch("http://localhost/HW/check_userEmail.php?" + encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value)).then(onResponse).then(onJson);
}


function validateSignUp(e) {
    const regExpText = new RegExp("^[a-zA-Z0-9_]{1,32}$");
    const regExpEmail = new RegExp(/^[^ ]+@[^ ]+\.[a-z]{2,3}$/); // Nel "validateLogin-js.js" non vi è bisogno di controllare il campo "Username o indirizzo E-mail" per quanto riguarda la presenza o meno di caratteri non accettati dall'username in fase di registrazione, come "/", in quanto in fase di registrazione sono accettati indirizzi email contenenti qualsiasi sequenze di caratteri separate da "@" e terminanti con una stringa ".xx(x)", dove gli ultimi 2 o 3 caratteri sono alfabetici
    const regExpPasswordNums = new RegExp("(?=.*[0-9])");
    const regExpPasswordUpperCase = new RegExp("(?=.*[A-Z])");
    const regExpPasswordLowerCase = new RegExp("(?=.*[a-z])");
    const regExpPasswordSpecialChars = new RegExp("(?=.*[!@#\$%\^&\*])");
    const regExpPasswordLength = new RegExp("(?=.{8,16})");

    if(userErr == 1 || emailErr == 1)
    {
        alert("Correggere i campi segnalati prima di procedere!");
        e.preventDefault();
        return;
    }
    
    for( const elem of signUp.elements)
    {
        if(elem.type != "submit")
        {
            if( elem.type != "password" && elem.name != "email")
            {
                if(!regExpText.test(elem.value))
                {
                    alert(elem.parentNode.textContent + "non valido!");
                    e.preventDefault();
                }
            }
            if (elem.name == "email")
            {
                if(!regExpEmail.test(elem.value))
                {
                    alert(elem.parentNode.textContent + "non valido!");
                    e.preventDefault();
                }
            }
            if(elem.name == "password")
            {
                if(!regExpPasswordNums.test(elem.value))
                {
                    alert("Inserire almeno un numero!");
                    e.preventDefault();
                }
                if(!regExpPasswordUpperCase.test(elem.value))
                {
                    alert("Inserire almeno un carattere maiuscolo!");
                    e.preventDefault();
                }
                if(!regExpPasswordLowerCase.test(elem.value))
                {
                    alert("Inseire almeno un carattere minuscolo!");
                    e.preventDefault();
                }
                if(!regExpPasswordSpecialChars.test(elem.value))
                {
                    alert("Inserire almeno un carattere speciale! (!,@,#,$,%,^,&,*)");
                    e.preventDefault();
                }
                if(!regExpPasswordLength.test(elem.value))
                {
                    alert("Lunghezza minima password: 8\nLunghezza massima password: 16");
                    e.preventDefault();
                }
            }
        }
    }

    if(signUp.check_password.value.length == 0)
    {
        alert("Conferma Password richiesta!");
        e.preventDefault();
    }

    if((signUp.password.value !== signUp.check_password.value) && signUp.check_password.value.length > 0)
    {
        alert("Password non conicidenti!");
        e.preventDefault();
    }

    // if( signUp.name.value.length == 0 ||
    //     signUp.surname.value.length == 0 ||
    //     signUp.user.value.length == 0 ||
    //     signUp.email.value.length == 0 ||
    //     signUp.password.value.length == 0 ||
    //     signUp.check_password.value.length == 0 )
    //     {
    //         alert("Compilare tutti i campi!");
    //         e.preventDefault();
    //     }
}

const signUp = document.forms['signup-form'];

signUp.addEventListener('submit', validateSignUp);

signUp.user.addEventListener('blur', checkFieldTaken);
signUp.email.addEventListener('blur', checkFieldTaken);