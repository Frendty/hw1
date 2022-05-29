<?php
    require_once 'db_connection.php';
    session_start();

    function authenticate() {
        GLOBAL $dbconnect;
        if(!isset($_SESSION['user'])) {
            // if(isset($_COOKIE['id']) && isset($_COOKIE['cookie_id']))
            // {
            //     $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

            //     $cookie_id = $_COOKIE['cookie_id'];
            //     $user_id = $_COOKIE['id'];

            //     $query = "SELECT * FROM cookies WHERE id = $cookie_id AND user = $user_id";

            //     $res = mysqli_query($conn, $query);

            //     $cookie = mysqli_fetch_assoc($res);

            //     if(isset($cookie)) {
            //         if(time() > $cookie['expires'])
            //         {
            //             $query = "DELETE FROM cookies WHERE id = ".$cookie['id']."";
            //             mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

            //             header("Location: logout.php");

            //             mysqli_free_result($res);
            //             mysqli_close($conn);
                        
            //             exit;
            //         }
            //         else
            //         {
            //             $_SESSION['user'] = $_COOKIE['id'];

            //             mysqli_free_result($res);
            //             mysqli_close($conn);

            //             return $_SESSION['user'];
            //         }
            //     }
            //     mysqli_free_result($res);
            //     mysqli_close($conn);
            // }

            return 0;
        }
        else
        {
            return $_SESSION['user'];
        }
    }
?>