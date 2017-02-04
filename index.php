<?php
require_once('session.php');
require_once('Db.php');

$page = isset($_GET['page']) && intval($_GET['page']) > 0 ? $_GET['page'] : 0;
$limit = 50;
$offset = $limit * $page;

$db = new Db();
$result = $db->paginateQuestionsTable($limit, $offset);
$totalPages = ceil($result['total'] / $limit);
$links = 4;
$start = ($page - $links) > 0 ? $page - $links : 1;
$end = ($page + $links) < $totalPages ? $page + $links : $totalPages;

include_once('header.php');
?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1 class="text-center">Questions Listing</h1>
            <div class="row">
                <div class="col-md-6">
                    <p>Total number of questions: <strong><?php echo $result['total']; ?></strong></p>
                </div>
                <div class="col-md-6 text-right">
                    <a href="prepare_html.php" target="_blank" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download PDF</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Subject</th>
                        <th>Exam Type</th>
                        <th>Complexity</th>
                        <th>Question</th>
                        <th>Created date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result['questionCount'] == 0): ?>
                    <tr><td colspan="6">There are no questions.</td></tr>
                    <?php else: ?>
                    <?php $count = 0; ?>
                    <?php foreach($result['questions'] as $question): ?>
                    <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $question['name']; ?></td>
                        <td><?php echo $question['exam_type']; ?></td>
                        <td><?php echo $question['complexity']; ?></td>
                        <td><?php echo $question['question']; ?></td>
                        <td><?php echo date('H:i:s d-m-Y', strtotime($question['created_at'])); ?></td>
                        <td><a href="add.php?id=<?php echo $question['id']; ?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($start != $end): ?>
        <nav aria-label="Page navigation" class="text-center">
            <ul class="pagination">
                <li<?php if($page == 0) echo ' class="disabled"'; ?>>
                    <a aria-label="Previous"<?php if($page) echo ' href="?page='.($page-1).'"';?>> <span aria-hidden="true">«</span> </a>
                </li>
                <?php foreach(range($start,$end) as $number):?>
                <li<?php if($number-1 == $page) echo ' class="active"'; ?>><a href="?page=<?php echo $number-1;?>"><?php echo $number; ?></a></li>
                <?php endforeach; ?>
                <li<?php if($page+1 >= $totalPages) echo ' class="disabled"'; ?>>
                    <a aria-label="Next"<?php if($page+1 < $totalPages) echo ' href="?page='.($page+1).'"';?>> <span aria-hidden="true">»</span> </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>
<?php include_once('footer.php'); ?>
