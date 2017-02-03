<?php
require_once('Db.php');

$db = new Db();
$subjects = $db->getSubjectsAsList();

if(isset($_GET['id'])) {
    $question = $db->getQuestion($_GET['id']);
    if(count($question) == 0) {
        header('Location: index.php');
    }
}

/*Array
(
    [id] => 6
    [subject_id] => 2
    [exam_type] => IIT
    [complexity] => Simple
    [question_type] => text
    [question] => The candidates, who are preparing for the engineering entrance exam of JEE Main and JEE advanced, should solve the AIEEE past year papers and IIT JEE past year papers. In order to understand the nature and type and the format of questions that are asked in JEE Main and JEE Advanced exams, a student needs to solve and then refer to the solutions at the end of the paper.
    [option_a_type] => text
    [option_a] =>
    [option_b_type] => text
    [option_b] =>
    [option_c_type] => text
    [option_c] =>
    [option_d_type] => text
    [option_d] =>
    [answer] => A
    [comments] =>
    [created_at] => 2017-02-03 21:47:20
    [updated_at] => 2017-02-03 21:47:20
)*/


include_once('header.php');
?>
<h4>Please enter the data</h4>
<?php if(isset($_GET['id'])): ?>
    <h3 class="danger">Please upload the images to the question when editing.</h3>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <form action="save_form.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="required_field">Exam type</label>
                        <label class="radio-inline">
                            <input type="radio" name="exam_type" value="IIT" class="exam_type_radio" <?php if(isset($_GET['id']) && $question['exam_type'] == 'IIT') echo 'checked'; ?>> IIT
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="exam_type" value="NEET" class="exam_type_radio" <?php if(isset($_GET['id']) && $question['exam_type'] == 'NEET') echo 'checked'; ?>> NEET
                        </label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="required_field">Complexity of the Question</label>
                        <?php foreach(array('Simple', 'Medium', 'Hard') as $complexity): ?>
                        <label class="radio-inline">
                            <input type="radio" name="complexity" value="<?php echo $complexity; ?>" class="complexity_radio" <?php if(isset($_GET['id']) && $question['complexity'] == $complexity) echo 'checked'; ?>> <?php echo $complexity; ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="required_field">Subject</label>
                        <?php foreach($subjects as $key => $subject): ?>
                        <label class="radio-inline">
                            <input type="radio" name="subject" class="subject" value="<?php echo $key; ?>" class="complexity_radio" <?php if(isset($_GET['id']) && $question['subject_id'] == $key) echo 'checked'; ?>> <?php echo $subject; ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="form-group top20">
                <label class="required_field">Question</label>
                <label class="radio-inline">
                    <input type="radio" name="question_radio" class="input_type" value="text" <?php echo isset($_GET['id']) && $question['question_type'] != 'text'? '' : 'checked'; ?>> Text
                </label>
                <label class="radio-inline">
                    <input type="radio" name="question_radio" class="input_type" value="image" <?php if(isset($_GET['id']) && $question['question_type'] == 'image') echo 'checked'; ?>> Image
                </label>
                <textarea class="form-control text_area" id="question" name="question" rows="4"></textarea>
                <input type="file" class="file_upload hidden" id="question_image" name="question_image">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>A</label>
                        <label class="radio-inline">
                            <input type="radio" name="option_a" class="input_type" value="text" <?php echo isset($_GET['id']) && $question['option_a_type'] != 'text'? '' : 'checked'; ?>> Text
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="option_a" class="input_type" value="image" <?php if(isset($_GET['id']) && $question['option_a_type'] == 'image') echo 'checked'; ?>> Image
                        </label>
                        <textarea class="form-control text_area" name="answer_a" rows="4"></textarea>
                        <input type="file" class="file_upload hidden" name="answer_a_image">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>B</label>
                        <label class="radio-inline">
                            <input type="radio" name="option_b" class="input_type" value="text" <?php echo isset($_GET['id']) && $question['option_b_type'] != 'text'? '' : 'checked'; ?>> Text
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="option_b" class="input_type" value="image" <?php if(isset($_GET['id']) && $question['option_b_type'] == 'image') echo 'checked'; ?>> Image
                        </label>
                        <textarea class="form-control text_area" name="answer_b" rows="4"></textarea>
                        <input type="file" class="file_upload hidden" name="answer_b_image">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>C</label>
                        <label class="radio-inline">
                            <input type="radio" name="option_c" class="input_type" value="text" <?php echo isset($_GET['id']) && $question['option_c_type'] != 'text'? '' : 'checked'; ?>> Text
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="option_c" class="input_type" value="image" <?php if(isset($_GET['id']) && $question['option_c_type'] == 'image') echo 'checked'; ?>> Image
                        </label>
                        <textarea class="form-control text_area" name="answer_c" rows="4"></textarea>
                        <input type="file" class="file_upload hidden" name="answer_c_image">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>D</label>
                        <label class="radio-inline">
                            <input type="radio" name="option_d" class="input_type" value="text" <?php echo isset($_GET['id']) && $question['option_d_type'] != 'text'? '' : 'checked'; ?>> Text
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="option_d" class="input_type" value="image" <?php if(isset($_GET['id']) && $question['option_d_type'] == 'image') echo 'checked'; ?>> Image
                        </label>
                        <textarea class="form-control text_area" name="answer_d" rows="4"></textarea>
                        <input type="file" class="file_upload hidden" name="answer_d_image">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required_field">Key</label>
                        <?php foreach(array('A', 'B', 'C', 'D') as $answer): ?>
                        <label class="radio-inline">
                            <input type="radio" name="answer" value="<?php echo $answer; ?>" class="answer_radio" <?php if(isset($_GET['id']) && $question['answer'] == $answer) echo 'checked'; ?>> <?php echo $answer; ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea class="form-control" name="comments" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <button type="submit" class="btn btn-primary saveForm">SAVE</button>
            </div>
        </form>
    </div>
</div>
<?php include_once('footer.php'); ?>
