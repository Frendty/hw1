<?php
    require_once 'authentication.php';

    if (!$userid = authenticate())
    {
        exit;
    }

    header('Content-Type: application/json');

    $query = $_GET["query"];
    $query = urlencode($query);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.unsplash.com/search/photos?page=1&query=$query&client_id=MATdJsVB23RNNFWOLJ2L7Ptaj6gu6PX0bM7boMOK0Wk&per_page=9");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($curl);

    echo $res;
    
    curl_close($curl);
?>