<?php
session_start();

if(!$_SESSION['loggedIn']) {
    header("Location: login.php");
}

/**
 * Image URL location
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  string $filename
 *
 * @return string
 */
function imageUrl($fileName) {
    return '<img src="/uploads/'.$fileName.'" class="img-rounded img-responsive">';
}