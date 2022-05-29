<?php
    include 'authentication.php';

    if(authenticate())
    {
        header("Location: home1.php");
        exit;
    }

    if(isset($_POST["user"]) && isset($_POST["password"]))
    {
        $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

        $username = mysqli_real_escape_string($conn, $_POST['user']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        //Istruzione necessaria per capire se cercare un username oppure un email nel database, dato che il login può essere eseguito in entrambi i modi
        $choose = filter_var($username, FILTER_VALIDATE_EMAIL) ? "email" : "username";

        $query = "SELECT id, username, password FROM users WHERE $choose = '$username'";

        $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

        if(mysqli_num_rows($res) > 0)
        {
            $user = mysqli_fetch_assoc($res);
            if(password_verify($_POST["password"], $user["password"]))
            {
                $_SESSION["user"] = $user["username"];
                // else
                // {
                //     $expires = strtotime("+1 minute");
                //     $query = "INSERT INTO cookies(user, expires) VALUES('".$user['id']."', ".$expires.")";
                //     $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
                //     setcookie("id", $user["id"], $expires);
                //     setcookie("cookie_id", mysqli_insert_id($conn), $expires);
                // }
                header("Location: home1.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
            else
            {
                $err = "";
            }
        }
        else
        {
            $err = "Username e/o password errati.";
        }

        mysqli_free_result($res);
        mysqli_close($conn);
        // exit;
    }
    else if(isset($_POST["username"]) || isset($_POST["password"]))
    {
        $err = "Inserisci username e/o password.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>HW - LOGIN</title>
        <link rel="stylesheet" href="css.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <script defer="true" src="validateLogin-js.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <article>
            <section>
                <div id="login-box">
                    <form name='login-form' method="POST">
                        <span class="title">Accedi</span>
                        <?php
                            if(isset($err))
                            {
                                echo "<p class = 'error'>Credenziali non valide!</p>";
                            }
                        ?>
                        <div class="wrap-input">
                            <label>Username o indirizzo E-mail <input type="text" name="user" placeholder="Username" <?php if(isset($_POST["user"])){echo "value=".$_POST["user"];} ?> ></label>
                            <span class="focus-input" data-symbol=""></span>
                        </div>
                        <div class="wrap-input">
                            <label>Password <input type="password" name="password" placeholder="Password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?> ></label>
                            <span class="focus-input" data-symbol=""></span>
                        </div>
                        <div class="container-signin-optns right">
                        <!--<label>Resta connesso <input type="checkbox" name="remember_me" value="1" <php if(isset($_POST["remember"])){echo $_POST["remember"] ? "checked" : "";} > ></label>--><a href="signup.php">Non sei iscritto? Registrati!</a>
                        </div>
                        <div class="container-submit-form-btn">
                            <div class="wrap-submit-form-btn">
                                <div class="bg-submit-form-btn"></div>
                                <label class="flex-centered submit"><input type="submit" value="Accedi"></label>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </article>
    </body>
</html>