<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $urls = [];
    $urls = [];
    $validFiles = [];
    $extensions = ["png" => "image/png", "jpg" => "image/jpg", "jpeg" => "image/jpeg"];
    $maxFileSize = 20 * 1024 * 1024;
    $uploadDir = "uploads/photo-evidence/";
    $uploadUrl = "http://localhost/dechaudit/$uploadDir";
    if (isset($_FILES["photos"])) {
        $photos = $_FILES["photos"]["name"];
        $names = $_POST["names"];
        foreach ($photos as $key => $file) {
            $filename = $_FILES["photos"]["name"][$key];
            $filetype = $_FILES["photos"]["type"][$key];
            $fileTmp = $_FILES["photos"]["tmp_name"][$key];
            $filesize = $_FILES["photos"]["size"][$key];
            if (!in_array($filetype, $extensions)) {
                $errors[$key] = "Image for " . $names[$key] . " is not a valid image";
            } else {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!array_key_exists(strtolower($ext), $extensions)) {
                    $errors[$key] = "Image for " . $names[$key] . " is not a valid image";
                } else {
                    if ($filesize > $maxFileSize) {
                        $errors[$key] = "Image for " . $names[$key] . " is too large";
                    } else {
                        $validFiles[$key] = $fileTmp;
                    }
                }
            }
        }
    }

    if (count($validFiles) == count($_POST["names"])) {
        foreach ($validFiles as $key => $value) {
            $mt = mt_rand();
            $newFileName = uniqid("$mt-") . ".png";
            move_uploaded_file($value, $uploadDir . $newFileName);
            $url = $uploadUrl . $newFileName;
            $urls[$names[$key]] = $url;
        }
    }
    echo json_encode([
        "errors" => $errors,
        "urls" => $urls
    ]);
} else
    echo json_encode([]);
