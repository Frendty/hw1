<?php
    require_once 'authentication.php';

    if (!$userid = authenticate())
    {
        exit;
    }

    header('Content-Type: application/json');

    
    $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());
    
    //Stringa di ricerca
    $qString = $_GET['qString'];
    $qString = mysqli_real_escape_string($conn, $qString);


    $query = "SELECT * FROM users WHERE username LIKE '%$qString%'";

    $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

    if(mysqli_num_rows($res) > 0)
    {
        $row = mysqli_fetch_assoc($res);
        $user = $row['username'];
        $query = "SELECT count(*) as num FROM friends WHERE friends.user IN (SELECT id FROM users WHERE username = '$user');";

        $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
    
        if($row = mysqli_fetch_assoc($res))
        {
            $count = $row['num'];
        }

        echo json_encode(array('username' => "$user", 'count' => "$count"));
    }

    mysqli_free_result($res);
    mysqli_close($conn);
    exit;
?>