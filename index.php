<?php
require_once('db.php');

$valid_passwords = array ("admin" => "secret");
$valid_users = array_keys($valid_passwords);

$user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
$pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
  header('WWW-Authenticate: Basic realm="JEE Questions"');
  header('HTTP/1.0 401 Unauthorized');
  die ("Unauthorized access is prohibited");
}

$db = new Db();
$subjects = $db->getSubjectsAsList();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">
        <title>Falcon First</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/custom.css" rel="stylesheet">
    </head>
    <body>
        <!-- Begin page content -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form action="save_form.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Question</label>
                            <label class="radio-inline">
                                <input type="radio" name="question_radio" class="input_type" value="text" checked> Text
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="question_radio" class="input_type" value="image"> Image
                            </label>
                            <textarea class="form-control text_area" id="question" name="question" rows="4"></textarea>
                            <input type="file" class="file_upload hidden" id="question_image" name="question_image">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>A</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_a" class="input_type" value="text" checked> Text
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_a" class="input_type" value="image"> Image
                                    </label>
                                    <textarea class="form-control text_area" name="answer_a" rows="4"></textarea>
                                    <input type="file" class="file_upload hidden" name="answer_a_image">
                                </div>
                                <div class="form-group">
                                    <label>C</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_c" class="input_type" value="text" checked> Text
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_c" class="input_type" value="image"> Image
                                    </label>
                                    <textarea class="form-control text_area" name="answer_c" rows="4"></textarea>
                                    <input type="file" class="file_upload hidden" name="answer_c_image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>B</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_b" class="input_type" value="text" checked> Text
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_b" class="input_type" value="image"> Image
                                    </label>
                                    <textarea class="form-control text_area" name="answer_b" rows="4"></textarea>
                                    <input type="file" class="file_upload hidden" name="answer_b_image">
                                </div>
                                <div class="form-group">
                                    <label>D</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_d" class="input_type" value="text" checked> Text
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="option_d" class="input_type" value="image"> Image
                                    </label>
                                    <textarea class="form-control text_area" name="answer_d" rows="4"></textarea>
                                    <input type="file" class="file_upload hidden" name="answer_d_image">
                                </div>
                            </div>
                        </div>
                        <div class="row top20 text-center">
                            <div class="form-group">
                                <label>Subject</label>
                                <select name="subject" id="subject">
                                    <option value="">Please select</option>
                                    <?php foreach($subjects as $key => $subject): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $subject; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row text-center">
                            <button type="submit" class="btn btn-primary saveForm">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container text-center">
                <span class="text-muted">&copy; Falcon First</span>
            </div>
        </footer>
        <!-- Bootstrap core JavaScript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery-3.1.1.slim.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>