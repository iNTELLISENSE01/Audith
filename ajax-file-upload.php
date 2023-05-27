<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $files = $_FILES;
    echo json_encode($files);
} else
    echo json_encode([]);
