<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $body = $_POST["data"];
    $request = json_decode($body, true);
    $response = json_encode($request["introduction"]);
    echo $response;
} else
    echo json_encode([]);
