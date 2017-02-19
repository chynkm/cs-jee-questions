<?php
require_once('session.php');
require_once('Db.php');

$db = new Db();
$total = $db->countAllResults('questions');
$summary = $db->getSummary();
$subjects = $db->getSubjectsAsList();

include_once('header.php');
?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1 class="text-center">Questions Summary</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <caption>Total number of questions: <strong><?php echo $total; ?></strong></caption>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <?php foreach (examTypes() as $examType): ?>
                        <th colspan="6" class="text-center"><?php echo $examType; ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>Complexity</th>
                        <?php foreach (examTypes() as $repetition): ?>
                        <?php foreach (complexities() as $complexity): ?>
                        <th class="text-center"><?php echo $complexity; ?></th>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <th scope="row"><?php echo $subject; ?></th>
                        <?php foreach (examTypes() as $examType): ?>
                        <?php foreach (complexities() as $complexity): ?>
                        <td class="text-right"><?php echo isset($summary[$subject][$examType][$complexity]) ? $summary[$subject][$examType][$complexity] : 0; ?></td>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="page-header">
            <h1 class="text-center">Download Questions</h1>
        </div>
        <div class="row">
            <form class="form-inline" action="prepare_html.php" method="post">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="required_field">Exam type</label>
                        <select name="exam_type" class="form-control" id="exam_type">
                        <?php foreach(array_merge(array('all'), examTypes()) as $exam): ?>
                        <option value="<?php echo $exam; ?>"><?php echo ucfirst($exam); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="required_field">Complexity of the Question</label>
                        <select name="complexity" class="form-control" id="complexity">
                        <?php foreach(array_merge(array('all'), complexities()) as $complexity): ?>
                        <option value="<?php echo $complexity; ?>"><?php echo ucfirst($complexity); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="required_field">Subject</label>
                        <select name="subject" class="form-control" id="subject">
                        <?php foreach(array('all' => 'All')+$subjects as $key => $subject): ?>
                        <option value="<?php echo $key; ?>"><?php echo $subject; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 top20 text-center">
                    <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download PDF</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
