<?php
require_once('session.php');
require_once('Db.php');

define('WKHTMLTOPDF', '/usr/local/bin/wkhtmltopdf.sh');

$db = new Db();
$questions = $db->getAllQuestions();

unlink('questions.html');
$file = 'questions.html';

$html = <<<QUES
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/template.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">

QUES;

file_put_contents($file, $html, FILE_APPEND);
$n = 0;

// foreach($questions as $question) {
if($questions != array()) {
    while($question = $questions->fetch_assoc()) {
    $n++;

    $origQuestion = $question['question_type'] == 'text' ? $question['question'] : imageUrl($question['question']);

    $optionA = $question['option_a_type'] == 'text' ? $question['option_a'] : imageUrl($question['option_a']);
    $optionB = $question['option_b_type'] == 'text' ? $question['option_b'] : imageUrl($question['option_b']);
    $optionC = $question['option_c_type'] == 'text' ? $question['option_c'] : imageUrl($question['option_c']);
    $optionD = $question['option_d_type'] == 'text' ? $question['option_d'] : imageUrl($question['option_d']);

    $html = <<<QUES
                <div class="row">
                    <div class="col-md-12">
                        <h2>Question $n</h2>
                        $origQuestion
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-6">
                        <strong>A.</strong>
                        $optionA
                    </div>
                    <div class="col-md-6">
                        <strong>B.</strong>
                        $optionB
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-6">
                        <strong>C.</strong>
                        $optionC
                    </div>
                    <div class="col-md-6">
                        <strong>D.</strong>
                        $optionD
                    </div>
                </div>

QUES;

    $answer = isset($question['answer']) ? $question['answer'] : '';
    $complexity = isset($question['complexity']) ? $question['complexity'] : '';
    $html .= <<<QUES
                <div class="row top10">
                    <div class="col-md-6">
                        <strong>Answer:</strong> {$answer}
                    </div>
                    <div class="col-md-6">
                        <strong>Complexity:</strong> {$complexity}
                    </div>
                </div>

QUES;

    $comments = isset($question['comments']) ? $question['comments'] : '';
    $exam = isset($question['exam_type']) ? $question['exam_type'] : '';
    $subject = isset($question['name']) ? $question['name'] : '';
    $html .= <<<QUES
                <div class="row top10">
                    <div class="col-md-12">
                        <strong>Comments:</strong>
                        {$comments}
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-6">
                        <strong>Exam:</strong> {$exam}
                    </div>
                    <div class="col-md-6">
                        <strong>Subject:</strong> {$subject}
                    </div>
                </div>

QUES;

    file_put_contents($file, $html, FILE_APPEND);
    }
}

$html = <<<QUES
        </div>
    </body>
</html>
QUES;

file_put_contents($file, $html, FILE_APPEND);

exec(WKHTMLTOPDF.' '.getcwd()."/questions.html questions.pdf > /dev/null &");

$fileName = 'Questions-'.date('H-i-s-d-m-Y').'.pdf';
$fileUrl = 'http://'.$_SERVER['SERVER_NAME'].'/questions.pdf';
header('Content-type: application/pdf');
header("Content-disposition: attachment; filename=\"".$fileName."\"");
readfile($fileUrl);
exit;

