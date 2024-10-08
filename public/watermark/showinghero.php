<?php
if(isset($_GET["type"])){
	if($_GET["type"] == "image") header("Content-Type: image/jpeg");
    echo file_get_contents($_GET['url']);
} else {
    $url = $_GET['url'];
    $options = [
      
        "http" => [
            "header" => "User-Agent: Mozilla/5.0\r\n"
        ],
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];

    $context = stream_context_create($options);
    $data = @file_get_contents($url, false, $context);

    if ($data === FALSE) {
        echo "Error fetching the URL.";
    } else {
        echo $data;
    }
}

?>
