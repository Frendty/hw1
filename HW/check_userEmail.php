<?php
    include 'db_connection.php';

    if(isset($_GET['user']))
    {
        header('Content-Type: application/json');

        $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

        $user = $_GET['user'];
        $user = mysqli_real_escape_string($conn, $user);
        
        $query = "SELECT username From users WHERE username = '$user'";

        $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

        if(mysqli_num_rows($res) > 0)
        {
            echo json_encode(array("used" => true, "type" => "user"));
        }
        else
        {
            echo json_encode(array("used" => false, "type" => "user"));
        }
        
        mysqli_free_result($res);
        mysqli_close($conn);
    }

    if(isset($_GET['email']))
    {
        header('Content-Type: application/json');

        $conn1 = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

        $email = $_GET['email'];
        $email = mysqli_real_escape_string($conn1, $email);
        
        $query1 = "SELECT email From users WHERE email = '$email'";

        $res1 = mysqli_query($conn1, $query1) or die("Errore: ".mysqli_error($conn1));

        if(mysqli_num_rows($res1) > 0)
        {
            echo json_encode(array("used" => true, "type" => "email"));
        }
        else
        {
            echo json_encode(array("used" => false, "type" => "email"));
        }
        
        mysqli_free_result($res1);
        mysqli_close($conn1);
    }
?>