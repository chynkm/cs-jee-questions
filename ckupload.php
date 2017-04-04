<?php

if (($_FILES['upload'] == "none") || (empty($_FILES['upload']['name'])) ) {
    $message = "No file uploaded.";
}
else if ($_FILES['upload']["size"] == 0 || $_FILES['upload']["size"] > 2097152) {
    $message = 'The file size should be greater than 0 MB and less than 2 MB';
}
else if (
    ($_FILES['upload']["type"] != "image/gif") &&
    ($_FILES['upload']["type"] != "image/jpeg") &&
    ($_FILES['upload']["type"] != "image/jpg") &&
    ($_FILES['upload']["type"] != "image/png") ) {
    $message = "The image must be in either GIF, JPEG, JPG or PNG format.";
}
else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
    $message = "Something wrong with the upload. Please try again.";
}
else {
    $message = "";
    $file_ext = explode('.', $_FILES['upload']['name']);
    $file_ext = strtolower(end($file_ext));
    $url = 'uploads/ckeditor-'.date('Y-m-d-H-i-s').'-'.uniqid().'.'.$file_ext;
    $move = @move_uploaded_file($_FILES['upload']['tmp_name'], $url);

    if(!$move) {
        $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
        $message = $_FILES['upload']['tmp_name'].' '.$url;
    }
}

if(isset($_GET['responseType']) && $_GET['responseType'] == 'json') {
    if($message) {
        echo json_encode(array(
            "uploaded" => 0,
            "error" => array(
                "message" => $message
            )
        ));
        exit;
    }

    echo json_encode(array(
        "uploaded" => 1,
        "fileName" => $_FILES['upload']['name'],
        "url" => $url,
        "width" => 300,
        "height" => 200
    ));
    exit;
}

echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";

