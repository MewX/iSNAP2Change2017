<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$columnName = array('QuizID', 'Week', 'QuizName', 'QuizType', 'ExtraQuiz', 'Points');


try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            //$update = $_POST['update'];
            if ($update == 0) {
                // if edit misc quiz
                $week = $_POST['Week'];
                $quizID = $_POST['quizID'];
                $quizName = $_POST['QuizName'];
                $points = $_POST['Points'];
                $extraQuiz = $_POST['ExtraQuiz'];
                updateQuiz($conn, $quizID, $quizName, 1, $week, $extraQuiz);
                updateMiscSection($conn, $quizID, $points);

            } else if ($update == -1) {
                $quizID = $_POST['quizID'];
                deleteQuiz($conn, $quizID);
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}


try {
    $quizResult = getMiscQuizzes($conn);
    $topicResult = getTopics($conn);
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
    <?php require_once('navigation.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $pageNameForView; ?> Overview
                    <?php if (isset($_GET['week'])) { ?>
                        <div class="alert alert-info alert-dismissable" style="display: inline-block;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                                    onclick="location.href='quiz.php';">×
                            </button>
                            <i class="fa fa-info-circle"></i> <?php echo 'Week ' . $_GET['week']; ?>
                        </div>
                    <?php } ?>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Quiz Information Table <span class="glyphicon glyphicon-plus pull-right"></span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="datatables">
                                <?php require_once('table-head.php'); ?>
                                <tbody>
                                <?php for ($i = 0; $i < count($quizResult); $i++) {
                                    $quizID = $quizResult[$i]->QuizID;
                                    $quizType = getQuizType($conn, $quizID);
                                    $points = getQuizPoints($conn, $quizID);
                                    ?>
                                    <tr class="<?php if ($i % 2 == 0) {
                                        echo "odd";
                                    } else {
                                        echo "even";
                                    } ?>">
                                        <td style="display:none"><?php echo $quizID ?></td>
                                        <td><?php echo $quizResult[$i]->Week ?></td>
                                        <td><?php echo $quizResult[$i]->QuizName ?></td>
                                        <td><?php echo $quizType ?></td>
                                        <td><?php if($quizResult[$i]->ExtraQuiz==1) echo "Yes"; else echo "No"; ?></td>
                                        <td><?php echo $points ?>
                                            <span class="glyphicon glyphicon-remove pull-right"
                                                  aria-hidden="true"></span>
                                            <span class="pull-right" aria-hidden="true">&nbsp;</span>
                                            <a href="misc-editor.php?quizID=<?php echo $quizResult[$i]->QuizID ?>">
                                                <span class="glyphicon glyphicon-edit pull-right" aria-hidden="true">

                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <?php require_once('quiz-overview-notification.php'); ?>
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


<input type=hidden name="keyword" id="keyword" value="<?php if (isset($_GET['week'])) {
    echo $_GET['week'];
} ?>">
<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>
<!-- Page-Level Scripts -->
<script>
    //DO NOT put them in $(document).ready() since the table has multi pages
    var dialogInputArr = $('.dialoginput');
    var len = dialogInputArr.length;
    var pointsIndex = len - 1;
    var quizTypeIndex = len - 3;

    $('.glyphicon-edit').on('click', function () {
        $("label").remove(".error");
        $('#dialogTitle').text("Edit <?php echo $pageNameForView ?>");
        $('#update').val(0);
        for (i = 0; i < dialogInputArr.length; i++) {
            dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
        }
        //render the selector for extra quiz
        if($(this).parent().parent().children('td').eq(4).text().trim()=="No"){
            dialogInputArr.eq(4).html(
                "<option value='0' selected>No</option> <option value='1'>Yes</option>"
            );
        }else{
            dialogInputArr.eq(4).html(
                "<option value='0'>No</option> <option value='1' selected>Yes</option>"
            );
        }
    });

    $('.glyphicon-plus').on('click', function () {
        if (confirm("You can only create a new quiz in Quiz Overview, click OK to go that page") == true) {
            window.location.href='quiz.php';
        }
    });

    $('.glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this quiz? If you remove one quiz. All the questions and submission of this quiz will also get deleted (not recoverable). It includes learning material, questions and options, their submissions and your grading/feedback, not only the quiz itself.')) {
            $('#update').val(-1);
            for (i = 0; i < dialogInputArr.length; i++) {
                dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
            }
            $('#submission').submit();
        }
    });

    $('#btnSave').on('click', function(){
        console.log("save is clicked");
        $('#submission').validate({
            rules: {
                Week: {
                    required: true,
                    digits: true
                },
                QuizName: {
                    required: true
                },
                Points: {
                    required: true,
                    digits: true
                }
            }
        });
        console.log("valid");

        $('#submission').submit();
    });

    $(document).ready(function () {
        var table = $('#datatables').DataTable({
            responsive: true,
            "initComplete": function (settings, json) {
                $('.input-sm').eq(1).val($("#keyword").val().trim());
            },
            "order": [[1, "asc"]],
            "pageLength": 50,
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [0]}
            ]
        });
        //search keyword, exact match
        table.search(
            $("#keyword").val().trim(), true, false, true
        ).draw();
        //if quiz is saq-like, disable Points
        $("#QuizType").change(function () {
            if ($.inArray($(this).val().trim(), <?php echo json_encode($saqLikeQuizTypeArr); ?>) != -1) {
                dialogInputArr.eq(pointsIndex).attr('disabled', 'disabled');
            } else {
                dialogInputArr.eq(pointsIndex).prop('disabled', false);
            }
        });
    });
</script>
</body>

</html>
