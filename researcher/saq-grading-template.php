<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$columnName = array('QuizID', 'Week', 'StudentID', 'TopicName', 'ClassName', 'Username');

try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            if ($update == -1) {
                $quizID = $_POST['quizID'];
                $studentID = $_POST['studentID'];
                deleteSAQSubmission($conn, $quizID, $studentID);
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    if (SAQ_LIKE_SUBMISSION_TYPE == 'saq') {
        $submissionResult = getSAQSubmissions($conn);
    } else if (SAQ_LIKE_SUBMISSION_TYPE == 'video') {
        $submissionResult = getVideoSubmissions($conn);
    } else if (SAQ_LIKE_SUBMISSION_TYPE == 'image') {
        $submissionResult = getImageSubmissions($conn);
    } else if (SAQ_LIKE_SUBMISSION_TYPE == 'poster') {
        $submissionResult = getPosterSubmissions($conn);
    }
} catch (Exception $e) {
    debug_err($e);
}
db_close($conn);

?>
<!DOCTYPE html>
<html lang="en">

<!-- Header Library -->
<?php require_once('header-lib.php'); ?>

<body>

<div id="wrapper">
    <!-- Navigation Layout-->
    <?php require_once('navigation.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $pageNameForView; ?> Overview</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo $pageNameForView; ?> Information Table
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="datatables">
                                <thead>
                                <tr>
                                    <?php for ($i = 0; $i < count($columnName); $i++) { ?>
                                        <th <?php if ($i == 0 || $i == 2) {
                                            echo 'style="display:none"';
                                        } ?>><?php
                                            $parts = preg_split('/(?=[A-Z])/', $columnName[$i]);
                                            for($j=0;$j<count($parts);$j++){
                                                echo $parts[$j];
                                                echo " ";
                                            } ?></th>
                                    <?php } ?>
                                    <th>Score</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for ($i = 0; $i < count($submissionResult); $i++) {
                                    $quizID = $submissionResult[$i]->QuizID;
                                    $studentID = $submissionResult[$i]->StudentID; ?>
                                    <tr class="<?php if ($i % 2 == 0) {
                                        echo "odd";
                                    } else {
                                        echo "even";
                                    } ?>">
                                        <?php for ($j = 0; $j < count($columnName); $j++) { ?>
                                            <td <?php if ($j == 0 || $j == 2) {
                                                echo 'style="display:none"';
                                            } ?>>
                                                <?php if (strlen($submissionResult[$i]->$columnName[$j]) > 0) echo $submissionResult[$i]->$columnName[$j]; else echo 0; ?>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <?php
                                            $status = getQuizStatus($conn, $quizID, $studentID);
                                            if ($status == 'GRADED') {
                                                $stuQuizScore = $submissionResult[$i]->Grade;//getStuQuizScore($conn, $quizID, $studentID);
                                                $quizPoints = getQuizPoints($conn, $quizID);
                                                $percentage = $stuQuizScore / $quizPoints;
                                                echo $stuQuizScore . '/' . $quizPoints . '  (' . round(($stuQuizScore / $quizPoints * 100),2) . '%)';
                                            } else
                                                echo '-'; ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $status ?>
                                            <span class="glyphicon glyphicon-remove pull-right"
                                                  aria-hidden="true"></span>
                                            <span class="pull-right" aria-hidden="true">&nbsp;</span>
                                            <a href="saq-grader.php?quizID=<?php echo $quizID ?>&studentID=<?php echo $studentID ?>">
                                                <span class="glyphicon glyphicon-edit pull-right"
                                                      aria-hidden="true"></span></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <div class="well row">
                            <h4><?php echo $pageNameForView; ?> Overview Notification</h4>
                            <div class="alert alert-info">
                                <p>View quizzes by filtering or searching. You can create/update/delete any quiz.</p>
                            </div>
                            <div class="alert alert-danger">
                                <p><strong>Warning</strong> : If you remove one submission. All the data for the student in this
                                    submission will be removed.
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<form id="submission" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type=hidden name="update" id="update" value="-1" required>
    <input type=hidden name="studentID" id="studentID" value="" required>
    <input type=hidden id="quizID" name="quizID" value="" required>
</form>

<input type=hidden name="keyword" id="keyword" value="
      <?php
if (isset($_GET['studentID'])) {
    try {
        $studentID = $_GET['studentID'];
        $studentResult = getStudentUsername($conn, $studentID);
        echo $studentResult[0]->Username;
    } catch (Exception $e) {
        debug_err($e);
        echo '';
    }
} else
    echo '';
?>">

<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>
<!-- Page-Level Scripts -->
<script>
    //DO NOT put them in $(document).ready() since the table has multi pages
    $('.glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this submission?')) {
            $('#update').val(-1);
            $('#quizID').val($(this).parent().parent().children('td').eq(0).text().trim());
            $('#studentID').val($(this).parent().parent().children('td').eq(2).text().trim());
            $('#submission').submit();
        }
    });
    $(document).ready(function () {
        var table = $('#datatables').DataTable({
            responsive: true,
            "order": [[7, "desc"], [1, "asc"], [2, "asc"]],
            "pageLength": 100,
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [0]}
            ]
        })
        //search keyword, exact match
        table.search(
            $("#keyword").val().trim(), true, false, true
        ).draw();
    });
</script>
</body>

</html>
