<?php
session_start();

if(!isset($_SESSION['loggedIn']) || (isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn'])) {
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

/**
 * Different types of Question exam types
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return array
 */
function examTypes() {
    return array('General', 'IIT', 'NEET', 'Eamcet', 'NTSE');
}

/**
 * Different types of Question types
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return array
 */
function questionTypes($key = false) {
    $questionTypes = array(
        1 => 'Single answer',
        2 => 'More than one answer',
        3 => 'Comprehension',
        4 => 'Matrix matching',
        5 => 'Integer'
    );
    return $key === false ? $questionTypes : $questionTypes[$key];
}

/**
 * Complexities of Questions
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return array
 */
function complexities() {
    return range(0, 5);
}