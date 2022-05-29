<?php
    require_once 'authentication.php';

    if (!$userid = authenticate())
    {
        exit;
    }

    header('Content-Type: application/json');
    $arr = array();
    $newRow = array();
    $likesArr = array();
    
    $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

    $user = $_GET['user'];
    $user = mysqli_real_escape_string($conn, $user);
    
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
    
    $query1 = "SELECT * FROM likes WHERE user = $userId";
    
    $res1 = mysqli_query($conn, $query1) or die("Errore: ".mysqli_error($conn));
    
    while($row = mysqli_fetch_assoc($res1))
    {
        $likesArr[$row['post']] = true;
    }

    
    $query = "SELECT posts.id as id, users.username as user, nlikes, ncomments, url_image, description, time FROM posts JOIN users on posts.user = users.id WHERE username = '$user' ORDER BY posts.id DESC;";

    $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

    while($row = mysqli_fetch_assoc($res))
    {
        if(!isset($avatar))
        {
            $newRow['avatar'] = 'unset';
        }
        else
        {
            $newRow['avatar'] = $avatar;
        }

        if(isset($likesArr[$row['id']]))
        {
            $newRow['liked'] = true;
        }
        else
        {
            $newRow['liked'] = false;
        }

        $newRow['postId'] = $row['id'];
        $newRow['username'] = $row['user'];
        $newRow['timeElapsed'] = getTime($row['time']);
        $newRow['url_image'] = $row['url_image'];
        $newRow['nlikes'] = $row['nlikes'];
        $newRow['ncomments'] = $row['ncomments'];
        $newRow['description'] = $row['description'];
        $arr[] = $newRow; 
    }

    

    echo json_encode($arr);
    mysqli_free_result($res);
    mysqli_close($conn);
    exit;

    //Funzione per calcolare il tempo di pubblicazione del post
    function getTime($timestamp) {
        $oldTime = strtotime($timestamp); 
        $diff = time() - $oldTime;           
        $oldTime = date('d/m/y', $oldTime);

        if ($diff /60 <1) {
            return intval($diff%60)."sec";  
        } else if ($diff / 60 < 60) {
            return intval($diff/60)."min";
        } else if ($diff / 3600 <24) {
            return intval($diff/3600) ."h";
        } else if (intval($diff/86400) == 1) {
            return "Ieri";
        } else if ($diff/86400 < 30) {
            return intval($diff/86400) . "d";
        } else {
            return $oldTime; 
        }
    }
?>