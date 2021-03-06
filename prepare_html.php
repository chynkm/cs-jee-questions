<?php
set_time_limit(0);
require_once('session.php');
require_once('Db.php');

function displayHtml($content) {
    return html_entity_decode(nl2br($content));
}

$db = new Db();
$questions = $db->getAllQuestions(
    $_POST['exam_type'],
    $_POST['complexity'],
    $_POST['subject'],
    $_POST['type_of_question'],
    $_POST['topic'],
    $_POST['sub_topic'],
    $_POST['limit']
);

unlink('questions.html');
unlink('questions.pdf');
$file = 'questions.html';

$html = <<<'QUES'
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/template.css" rel="stylesheet" type="text/css" media="all">
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
        </script>
        <script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    </head>
    <body>
        <div class="container">
            <table class="table table-condensed table-bordered equalDivide">
                <tbody>

QUES;

file_put_contents($file, $html, FILE_APPEND);
$n = 0;

if($questions != array()) {
    while($question = $questions->fetch_assoc()) {
    $n++;

    $origQuestion = displayHtml($question['question']);
    $origQuestionImage = imageUrl($question['question_image']);

    $optionA = displayHtml($question['option_a']);
    $optionAImage = imageUrl($question['option_a_image']);
    $optionB = displayHtml($question['option_b']);
    $optionBImage = imageUrl($question['option_b_image']);
    $optionC = displayHtml($question['option_c']);
    $optionCImage = imageUrl($question['option_c_image']);
    $optionD = displayHtml($question['option_d']);
    $optionDImage = imageUrl($question['option_d_image']);

    $html = <<<QUES
            <tr>
                <th scope="row" colspan="4">Question $n</th>
            </tr>
            <tr>
                <td colspan="4">
                    {$origQuestion}
                    {$origQuestionImage}
                </td>
            </tr>
            <tr>
                <th scope="row" colspan="4">A</th>
            </tr>
            <tr>
                <td colspan="4">
                    {$optionA}
                    {$optionAImage}
                </td>
            </tr>
            <tr>
                <th scope="row" colspan="4">B</th>
            </tr>
            <tr>
                <td colspan="4">
                    {$optionB}
                    {$optionBImage}
                </td>
            </tr>
            <tr>
                <th scope="row" colspan="4">C</th>
            </tr>
            <tr>
                <td colspan="4">
                    {$optionC}
                    {$optionCImage}
                </td>
            </tr>
            <tr>
                <th scope="row" colspan="4">D</th>
            </tr>
            <tr>
                <td colspan="4">
                    {$optionD}
                    {$optionDImage}
                </td>
            </tr>
QUES;

    $answer = isset($question['answer']) ? $question['answer'] : '';
    $complexity = isset($question['complexity']) ? $question['complexity'] : '';
    $html .= <<<QUES
            <tr>
                <th scope="row">Answer:</th>
                <td>{$answer}</td>
                <th scope="row">Complexity:</th>
                <td>{$complexity}</td>
            </tr>
            <tr>
                <th scope="row">Topic:</th>
                <td>{$question['topic']}</td>
                <th scope="row">Sub topic:</th>
                <td>{$question['sub_topic']}</td>
            </tr>
QUES;

    $comments = isset($question['comments']) ? displayHtml($question['comments']) : '';
    $exam = isset($question['exam_type']) ? $question['exam_type'] : '';
    $subject = isset($question['name']) ? $question['name'] : '';
    $html .= <<<QUES
            <tr>
                <th scope="row">Exam:</th>
                <td>{$exam}</td>
                <th scope="row">Subject:</th>
                <td>{$subject}</td>
            </tr>
            <tr>
                <th scope="row">Comments:</th>
                <td colspan="3">{$comments}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
QUES;

    file_put_contents($file, $html, FILE_APPEND);
    }
}

$html = <<<QUES
                </tbody>
            </table>
        </div>
    </body>
</html>
QUES;

file_put_contents($file, $html, FILE_APPEND);

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

exec(WKHTMLTOPDF.' --javascript-delay 1000 -O landscape '.$protocol.$_SERVER['SERVER_NAME']."/questions.html questions.pdf > /dev/null");

$fileName = 'Questions-'.date('H-i-s-d-m-Y').'.pdf';
$fileUrl = $protocol.$_SERVER['SERVER_NAME'].'/questions.pdf';
header('Content-type: application/pdf');
header("Content-disposition: attachment; filename=\"".$fileName."\"");
readfile($fileUrl);
exit;

