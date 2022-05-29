<?php
    require_once 'authentication.php';

    if (!$userid = authenticate())
    {
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

    $user = $_SESSION['user'];

    $query_userId = "SELECT id FROM users WHERE username = '$user'";

    $res = mysqli_query($conn, $query_userId) or die("Errore: ".mysqli_error($conn));

    if(mysqli_num_rows($res) > 0)
    {
        $row = mysqli_fetch_assoc($res);

        $userId = $row['id'];
    }
    else
    {
        echo json_encode(array("error" => "nessun utente trovato!"));
        exit;
    }

    $userId = mysqli_real_escape_string($conn, $userId);

    $post = mysqli_real_escape_string($conn, $_GET["post"]);

    $query = "INSERT INTO likes(user, post) VALUES($userId, $post)";

    $res = mysqli_query($conn, $query) or die ('Errore: '. mysqli_error($conn));

    mysqli_close($conn);

    echo json_encode(array('ok' => false));
?>