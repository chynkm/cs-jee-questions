<?php
set_time_limit(900);
require_once('session.php');
require_once('Db.php');

$x = extract($_POST);

$question_image = isset($_FILES['question_image']['name']) ? fileUpload('question_image') : null;
$answer_a_image = isset($_FILES['answer_a_image']['name']) ? fileUpload('answer_a_image') : null;
$answer_b_image = isset($_FILES['answer_b_image']['name']) ? fileUpload('answer_b_image') : null;
$answer_c_image = isset($_FILES['answer_c_image']['name']) ? fileUpload('answer_c_image') : null;
$answer_d_image = isset($_FILES['answer_d_image']['name']) ? fileUpload('answer_d_image') : null;
$comments_image = isset($_FILES['comments_image']['name']) ? fileUpload('comments_image') : null;

$post['question'] = htmlentities($question);
$post['option_a'] = htmlentities($answer_a);
$post['option_b'] = htmlentities($answer_b);
$post['option_c'] = htmlentities($answer_c);
$post['option_d'] = htmlentities($answer_d);
$post['subject_id'] = $subject;
$post['exam_type'] = $exam_type;
$post['complexity'] = $complexity;
$post['answer'] = $answer;
$post['comments'] = $comments;
$post['comments_image'] = $comments_image;
$post['type_of_question'] = $type_of_question;
$post['topic'] = $topic;
$post['sub_topic'] = $sub_topic;

$db = new Db();
if(isset($_POST['id'])) {

    $columns = 'subject_id = ?, exam_type = ?, complexity = ?, type_of_question = ?, answer = ?, comments = ?, question = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, topic = ?, sub_topic = ?, updated_at = ?';
    $bindParams = 'ississsssssiis';
    $bindParamValues = array($post['subject_id'], $post['exam_type'], $post['complexity'], $post['type_of_question'], $post['answer'], $post['comments'], $post['question'], $post['option_a'], $post['option_b'], $post['option_c'], $post['option_d'], $post['topic'], $post['sub_topic'], date('Y-m-d H:i:s'));

    if($question_image) {
        $columns .= ', question_image = ?';
        $bindParams .= 's';
        array_push($bindParamValues, $question_image);
    }

    if($answer_a_image) {
        $columns .= ', option_a_image = ?';
        $bindParams .= 's';
        array_push($bindParamValues, $answer_a_image);
    }

    if($answer_b_image) {
        $columns .= ', option_b_image = ?';
        $bindParams .= 's';
        array_push($bindParamValues, $answer_b_image);
    }

    if($answer_c_image) {
        $columns .= ', option_c_image = ?';
        $bindParams .= 's';
        array_push($bindParamValues, $answer_c_image);
    }

    if($answer_d_image) {
        $columns .= ', option_d_image = ?';
        $bindParams .= 's';
        array_push($bindParamValues, $answer_d_image);
    }

    if($comments_image) {
        $columns .= ', comments_image = ?';
        $bindParams .= 's';
        array_push($bindParamValues, $comments_image);
    }

    $bindParams .= 'i';
    array_push($bindParamValues, $_POST['id']);

    $result = $db->updateQuestion($columns, $bindParams, $bindParamValues);
} else {

    $post['question_image'] = $question_image;
    $post['option_a_image'] = $answer_a_image;
    $post['option_b_image'] = $answer_b_image;
    $post['option_c_image'] = $answer_c_image;
    $post['option_d_image'] = $answer_d_image;

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

