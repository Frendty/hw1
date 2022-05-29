<?php
    require_once 'db_connection.php';

    session_start();

    session_destroy();

/*
    if(isset($_COOKIE['id']) && isset($_COOKIE['cookie_id']))
    {
        $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

        $cookie_id = $_COOKIE['cookie_id'];
        $user_id = $_COOKIE['id'];

        $query = "SELECT id FROM cookies WHERE id = $cookie_id AND user = $user_id";

        $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
        
        $cookie = mysqli_fetch_assoc($res);
        
        if(isset($cookie))
        {
            $query = "DELETE FROM cookies WHERE id = $cookie_id";
            mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
            mysqli_close($conn);
            setcookie('id', '');
            setcookie('cookie_id', '');
        }
        mysqli_free_result($res);
    }
*/


    header("Location: login.php");

    exit;
?>