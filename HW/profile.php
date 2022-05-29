<?php
    require_once 'authentication.php';

    if (!$userid = authenticate())
    {
        header("Location: login.php");
        exit;
    }

    $user = $_SESSION['user'];

    $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

    $query = "SELECT count(*) as num FROM friends WHERE friends.user IN (SELECT id FROM users WHERE username = '$user');";

    $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

    if($row = mysqli_fetch_assoc($res))
    {
        $count = $row['num'];
    }

    $query = "SELECT * FROM users WHERE username = '$user'";

    $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

    if(mysqli_num_rows($res) > 0)
    {
        $hidden = true;
    }
    else
    {
        $hidden = false;
    }

    mysqli_free_result($res);
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>HW - HOME</title>
        <link rel="stylesheet" href="home-css.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <script src="https://kit.fontawesome.com/87e20f3ca7.js" crossorigin="anonymous"></script>
        <script defer="true" src="profile.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
    </head>
    <body>
        <article>
            <header>
                <nav>
                    <ul class="menu">
                        <div>
                            <li class="logo"><a href="home1.php">PostZap</a></li>
                        </div>
                        <div>
                            <li><input type="text" class="search-box profile" placeholder="Cerca un profilo"></li>
                        </div>
                        <div id="last-menu-block">
                            <!-- <li class="menu-element btn profile"><a href="profile.php?q=myProfile"></a></li> -->
                            <li class="menu-element btn secondary"><a href="logout.php">Esci</a></li>
                        </div>
                    </ul>
                </nav>
            </header>
            <section>
                <div class="profile">
                    <i class="fa-solid fa-circle-user"></i>
                    <h1><?php echo "Ciao";?></h1>
                    <!-- <img class="headProfile" src=""> -->
                    <div class="numFollow">
                        <h1>Account seguiti: <?php if(isset($count)) {echo $count;} else { echo 'Error';}?></h1>
                    </div>
                    <div class="followBtn"> Segui</div>
                </div>
            </section>
        </article>
    </body>
</html>