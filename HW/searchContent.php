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

    
    $user = $_SESSION['user'];
    $user = mysqli_real_escape_string($conn, $user);

    $query = "";
    
    if (strlen(trim($qString)) == 0)
    {
        $query = "SELECT DISTINCT posts.id as id, users.username as user, nlikes, ncomments, url_image, description, time FROM posts JOIN users on posts.user = users.id LEFT JOIN friends ON posts.user = friends.user_friend WHERE (posts.user IN (SELECT users.id FROM users WHERE username = '$user') AND (description LIKE '')) OR (friends.user IN (SELECT users.ID FROM users WHERE users.username = '$user') AND (description LIKE '')) ORDER BY posts.id DESC;";
    }
    else
    {
        $qString = trim($qString);

        $query = "SELECT DISTINCT posts.id as id, users.username as user, nlikes, ncomments, url_image, description, time FROM posts JOIN users on posts.user = users.id LEFT JOIN friends ON posts.user = friends.user_friend WHERE (posts.user IN (SELECT users.id FROM users WHERE username = '$user') AND (lower(users.username) LIKE lower('%$qString%')) OR (lower(description) LIKE lower('%$qString%'))) OR (friends.user IN (SELECT users.ID FROM users WHERE users.username = '$user') AND (lower(users.username) LIKE lower('%$qString%')) OR (lower(description) LIKE lower('%$qString%'))) ORDER BY posts.id DESC;";
    }

    $res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));

    $arr = array();
    $newRow = array();

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