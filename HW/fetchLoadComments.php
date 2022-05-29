<?php 
    require_once 'authentication.php';
    if (!$userid = authenticate()) 
    {
        exit;
    }

    // Popolo il vettore $_POST con i dati inviati dalla fetch via JS
    $_POST = json_decode(file_get_contents("php://input"), true);
    
    header('Content-Type: application/json');
    
    if(!isset($_POST['post']))
    {
        echo json_encode(array("error" => "Nessun parametro 'post' impostato!"));
        exit;
    }

    $conn = mysqli_connect($dbconnect['host'], $dbconnect['user'], $dbconnect['password'], $dbconnect['database']) or die("Errore: ".mysqli_connect_error());

    $user = $_SESSION['user'];
    $post = $_POST['post'];

    $user = mysqli_real_escape_string($conn, $user);
    $post = mysqli_real_escape_string($conn, $post);

    if(isset($_POST['comment']))
    {
        // Ricerca id utente assiociato a 'user'
        $query_userId = "SELECT id FROM users WHERE username = '$user'";

        $res = mysqli_query($conn, $query_userId) or die("Errore: ".mysqli_error($conn));

        if(mysqli_num_rows($res) > 0)
        {
            $row = mysqli_fetch_assoc($res);
            $userId = $row['id'];
            mysqli_real_escape_string($conn, $userId);
        }

        $content = mysqli_real_escape_string($conn, $_POST["comment"]);
        $query = "INSERT INTO comments(user, post, content) VALUES($userId, $post, '$content')";
        mysqli_query($conn, $query) or die ("Errore: ".mysqli_error($conn));

        echo json_encode(array('result' => 'OK', 'postId' => $post));

        mysqli_close($conn);
        
        exit;
    }

    $query1 = "SELECT comments.id AS id, username, content, time FROM comments LEFT JOIN users ON user = users.id WHERE comments.post = $post ORDER BY time DESC";
    
    $res = mysqli_query($conn, $query1) or die (mysqli_error($conn));

    $arr = array();

    while($row = mysqli_fetch_assoc($res)) {
        //Fixare avatar
        if(!isset($avatar))
        {
            $row['avatar'] = "unset";
        }
        else
        {
            $row['avatar'] = $avatar;
        }

        $arr[] = array('id' => $row['id'], 'avatar' => $row['avatar'], 'postId' => $post, 'username' => $row['username'], 'content' => $row['content'], 'timeElapsed' => getTime($row['time']));

    }

    echo json_encode($arr);

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