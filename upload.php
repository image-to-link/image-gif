<?php
header('Content-Type: application/json');

$target_dir = "assets/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (isset($_FILES["image"])) {
    $file = $_FILES["image"];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

    if (!in_array($ext, $allowed)) {
        echo json_encode(["success" => false, "error" => "Only image formats (jpg, png, gif, webp) allowed."]);
        exit;
    }

    $uniqueName = uniqid("img_", true) . '.' . $ext;
    $target_file = $target_dir . $uniqueName;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $url = $protocol . "://" . $_SERVER['HTTP_HOST'] . '/' . $target_file;
        echo json_encode(["success" => true, "url" => $url]);
    } else {
        echo json_encode(["success" => false, "error" => "Upload failed."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded."]);
}
?>
