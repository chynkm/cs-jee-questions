<?php
require_once('session.php');
require_once('Db.php');

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

$post['subject_id'] = $subject;
$post['exam_type'] = $exam_type;
$post['complexity'] = $complexity;
$post['answer'] = $answer;
$post['comments'] = $comments;

$db = new Db();
if($_POST['id']) {

    $columns = 'subject_id = ?, exam_type = ?, complexity = ?, answer = ?, comments = ?';
    $bindParams = 'issss';
    $bindParamValues = array($post['subject_id'], $post['exam_type'], $post['complexity'], $post['answer'], $post['comments']);

    if($question) {
        $columns .= ', question_type = ?, question = ?';
        $bindParams .= 'ss';
        array_push($bindParamValues, $question_radio, $question);
    }

    if($answer_a) {
        $columns .= ', option_a_type = ?, option_a = ?';
        $bindParams .= 'ss';
        array_push($bindParamValues, $option_a, $answer_a);
    }

    if($answer_b) {
        $columns .= ', option_b_type = ?, option_b = ?';
        $bindParams .= 'ss';
        array_push($bindParamValues, $option_b, $answer_b);
    }

    if($answer_c) {
        $columns .= ', option_c_type = ?, option_c = ?';
        $bindParams .= 'ss';
        array_push($bindParamValues, $option_c, $answer_c);
    }

    if($answer_d) {
        $columns .= ', option_d_type = ?, option_d = ?';
        $bindParams .= 'ss';
        array_push($bindParamValues, $option_d, $answer_d);
    }

    $bindParams .= 'i';
    array_push($bindParamValues, $_POST['id']);

    $result = $db->updateQuestion($columns, $bindParams, $bindParamValues);
} else {

    $post['question_type'] = $question_radio;
    $post['question'] = $question;
    $post['option_a_type'] = $option_a;
    $post['option_a'] = $answer_a;
    $post['option_b_type'] = $option_b;
    $post['option_b'] = $answer_b;
    $post['option_c_type'] = $option_c;
    $post['option_c'] = $answer_c;
    $post['option_d_type'] = $option_d;
    $post['option_d'] = $answer_d;

    $result = $db->insertQuestion($post);
}

if($result) {
    $_SESSION['successFlash'] = 'Question saved successfully.';
} else {
    $_SESSION['errorFlash'] = 'Oh snap! There was an error in saving the question. Please try again';
}
header('Location: add.php');

function fileUpload($fieldName)
{
    if(isset($_FILES[$fieldName]) && $_FILES[$fieldName]['name'] != '') {
        $errors = array();
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

