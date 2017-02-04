<?php
$inputNames = array();
if(isset($_GET['id']) && $question['question_type'] == 'image') {
    $inputNames[] = 'question_radio';
}

if(isset($_GET['id']) && $question['option_a_type'] == 'image') {
    $inputNames[] = 'option_a';
}

if(isset($_GET['id']) && $question['option_b_type'] == 'image') {
    $inputNames[] = 'option_b';
}

if(isset($_GET['id']) && $question['option_c_type'] == 'image') {
    $inputNames[] = 'option_c';
}

if(isset($_GET['id']) && $question['option_d_type'] == 'image') {
    $inputNames[] = 'option_d';
}

if(count($inputNames)) {
$inputNames = json_encode($inputNames);
echo <<<JavaScript
    <script type="text/javascript">
    APP.main.imageSelect('$inputNames');
    </script>
JavaScript;
}
