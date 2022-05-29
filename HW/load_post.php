<?php
    require_once 'authentication.php';
    
    if (!$userid = authenticate())
    {
        exit;
    }

    
    header('Content-Type: application/json');
    
    if(!isset($_GET['url_image']) || !isset($_GET['description']))
    {
        echo json_encode(array("Errore" => "Controllare campi descrizione o immagine"));
    }

    $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

    $user = $_SESSION['user'];
    $user = mysqli_real_escape_string($conn, $user);

    $urlImage = $_GET['url_image'];
    $urlImage = mysqli_real_escape_string($conn, $urlImage);

    $description = $_GET['description'];
    $description = mysqli_real_escape_string($conn, $description);

    $query = "SELECT id FROM users WHERE username = '$user'";

    $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

    if(mysqli_num_rows($res) > 0)
    {
        if(!empty($urlImage))
        {
            $row = mysqli_fetch_assoc($res);
            $user_id = $row['id'];

            mysqli_free_result($res);

            $query = "INSERT INTO posts (user, nlikes, ncomments, url_image, description) VALUES ($user_id, 0, 0, '$urlImage', '$description');";

            $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

            if($res)
            {
                echo json_encode(array("result" => "OK"));
            }
        }
    }
    else
    {
        echo json_encode(array("error" => "Nessun Utente trovato!"));
    }

    mysqli_close($conn);
?>