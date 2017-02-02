<?php
require_once('db.php');

echo "<pre>";
print_r($_POST);
print_r($_FILES);

$x = extract($_POST);
if($question_radio == 'image') {
    $question = fileUpload('question_image');
}
if($option_a == 'image') {
    $answer_a = fileUpload('answer_a_image');
}
if($option_b == 'image') {
    $answer_b = fileUpload('answer_b_image');
}
if($option_c == 'image') {
    $answer_c = fileUpload('answer_c_image');
}
if($option_d == 'image') {
    $answer_d = fileUpload('answer_d_image');
}

$dataCol = "(subject_id, question_type, question, option_a_type, option_a, option_b_type, option_b, option_c_type, option_c, option_d_type, option_d)";
$dataVal = "($subject, '$question_radio', '$question', '$option_a', '$answer_a', '$option_b', '$answer_b', '$option_c', '$answer_c', '$option_d', '$answer_d')";

$db = new Db();
$result = $db->insert('questions', $dataCol, $dataVal);

if($result) {
    header('Location: index.php');
}

function fileUpload($fieldName)
{
    if(isset($_FILES[$fieldName])) {
        $errors= array();
        $file_name = $_FILES[$fieldName]['name'];
        $file_size = $_FILES[$fieldName]['size'];
        $file_tmp = $_FILES[$fieldName]['tmp_name'];
        $file_type = $_FILES[$fieldName]['type'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        $extensions= array("jpeg", "jpg", "png", "gif");

        if(in_array($file_ext, $extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if($file_size > 2097152){
            $errors[]='File size must be excatly 2 MB';
        }

        if(empty($errors)==true){
            $new_image_name = 'image-' . date('Y-m-d-H-i-s') . '-' . uniqid() . '.'.$file_ext;
            move_uploaded_file($file_tmp,"uploads/".$new_image_name);
            return $new_image_name;
        }else{
            print_r($errors);
        }
    }
}