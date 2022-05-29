<?php
    require_once 'authentication.php';

    if(authenticate()) {
        header("Location: home1.php");

        exit;
    }

    if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["user"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["check_password"]))
    {
        $err = array();
        $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());
        
        //Costanti per verifica successiva password
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $nums = '0123456789';
        $special_chars = '!@#$%^&*';

        //Controllo Dati Form

        //Username
        if(!preg_match('/^[a-zA-Z0-9_]{1,32}$/', $_POST["user"]))
        {
            $err[] = "Username non valido!";
        }
        else
        {
            $username = mysqli_real_escape_string($conn, $_POST["user"]);

            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

            if(mysqli_num_rows($res) > 0)
            {
                $err[] = "Username già in uso!";
            }

            mysqli_free_result($res);
        }

        //Password
        if(strlen($_POST["password"]) < 8 || strlen($_POST["password"]) > 16)
        {
            $err[] = "Errore lunghezza password!(min. 8 - max 16)";
        }

        if(str_contains($_POST["password"], $nums))
        {
            $err[] = "Errore password: è richiesto almeno un numero!";
        }

        if(str_contains($_POST["password"], strtoupper($alphabet)))
        {
            $err[] = "Errore password: è richiesto almeno un carattere maiuscolo!";
        }

        if(str_contains($_POST["password"], $alphabet))
        {
            $err[] = "Errore password: è richiesto almeno un carattere minuscolo!";
        }

        if(str_contains($_POST["password"], $special_chars))
        {
            $err[] = "Errore password: è richiesto almeno un carattere speciale! (!,@,#,$,%,^,&,*)";
        }

        if(strcmp($_POST["password"], $_POST["check_password"]) != 0)
        {
            $err[] = "Errore password: le due password non corrispondono!";
        }

        //Email
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        {
            $err[] = "Indirizzo e-mail invalido!";
        }
        else
        {
            $email = mysqli_real_escape_string($conn, strtolower($_POST["email"]));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'") or die("Errore:".mysqli_error($conn));
            
            if(mysqli_num_rows($res) > 0)
            {
                $err[] = "Email già in uso!";
            }

            mysqli_free_result($res);
        }

        //Registrazione
        if(count($err) == 0)
        {
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $surname = mysqli_real_escape_string($conn, $_POST["surname"]);

            $password = password_hash(mysqli_real_escape_string($conn, $_POST["password"]), PASSWORD_BCRYPT);

            $query = "INSERT INTO users(name, surname, username, email, password) VALUES('$name', '$surname', '$username', '$email', '$password')";

            if($res = mysqli_query($conn, $query))
            {
                $_SESSION["user"] = $_POST["user"];


                mysqli_close($conn);
                
                header("Location: home1.php");
                
                exit;
            }
            else
            {
                $err[] = "Errore di connessione al DB!";
            }
        }

        mysqli_close($conn);
    }
    else
    {
        $err = array();
        $err[] = "Compila tutti i campi!";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>HW - SIGNUP</title>
        <link rel="stylesheet" href="css.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <script defer="true" src="validateSignup-js.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <article>
            <section>
                <div id="login-box" class="register">
                    <form name='signup-form' method='post'>
                        <span class="title">Registrati</span>
                        <div class="wrap-fields">
                            <div class="wrap-input">
                                <label>Nome <input type="text" name="name" placeholder="Nome" <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];}?> ></label>
                                <span class="focus-input" data-symbol=""></span>
                            </div>
                            <div class="wrap-input">
                                <label>Cognome <input type="text" name="surname" placeholder="Cognome" <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];}?>></label>
                                <span class="focus-input" data-symbol=""></span>
                            </div>
                            <div class="wrap-input">
                                <label>Username <input type="text" name="user" placeholder="Username" <?php if(isset($_POST["user"])){echo "value=".$_POST["user"];}?>></label>
                                <span class="focus-input" data-symbol=""></span>
                                <p class="red hidden"></p>
                            </div>
                            <div class="wrap-input">
                                <label>Indirizzo E-mail <input type="text" name="email" placeholder="Indirizzo E-mail" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];}?>></label>
                                <span class="focus-input" data-symbol=""></span>
                                <p class="red hidden"></p>
                            </div>
                            <div class="wrap-input">
                                <label>Password <input type="password" name="password" placeholder="Password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];}?>></label>
                                <span class="focus-input" data-symbol=""></span>
                            </div>
                            <div class="wrap-input">
                                <label>Conferma Password <input type="password" name="check_password" placeholder="Conferma Password" <?php if(isset($_POST["check_password"])){echo "value=".$_POST["check_password"];}?>></label>
                                <span class="focus-input" data-symbol=""></span>
                            </div>
                        </div>
                        <div class="container-signup">
                            <a href="login.php">Sei già iscritto? Accedi!</a>
                        </div>
                        <div class="container-submit-form-btn">
                            <div class="wrap-submit-form-btn">
                                <div class="bg-submit-form-btn"></div>
                                <label class="flex-centered submit"><input type="submit" value="Registrati"></label>
                            </div>
                        </div>
                        <div>
                            <p><?php if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["user"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["check_password"])) {echo "Errori: "; print_r($err);}?></p>
                        </div>
                    </form>
                </div>
            </section>
        </article>
    </body>
</html>