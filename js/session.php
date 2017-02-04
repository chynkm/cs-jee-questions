<?php
session_start();
$message = '';

if(count($_POST)>0) {
    $db = new Db();
    $status = $db->verifyLogin($_POST['username'], $_POST['password']);
    if($status) {
        header("Location: index.php");
    } else {
        $message = "Invalid Username or Password!";
    }
}