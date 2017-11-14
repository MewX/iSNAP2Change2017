<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$parentPage = 'Location: mcq.php';
$columnName = array('MCQID', 'Question', 'Option', 'Explanation', 'Edit');

try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['metadataUpdate'])) {
            $metadataUpdate = $_POST['metadataUpdate'];
            if ($metadataUpdate == 0) {
                try {
                    $week = $_POST['Week'];
                    $quizID = $_POST['QuizID'];
                    $quizName = $_POST['QuizName'];
                    $points = $_POST['Points'];
                    $extraQuiz = $_POST['ExtraQuiz'];
                    updateQuiz($conn, $quizID, $quizName, 1, $week, $extraQuiz);
                    updateMiscSection($conn, $quizID, $points);
                } catch (Exception $e) {
                    debug_err($e);
                    $conn->rollBack();
                }
            } else if ($metadataUpdate == -1) {
                $quizID = $_POST['quizID'];
                deleteQuiz($conn, $quizID);
                header($parentPage);
            }
        }
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            if ($update == 1) {
                $quizID = $_POST['quizID'];
                $question = $_POST['question'];
                $mcqID = createMCQQuestion($conn, $quizID, $question);
                header('Location: mcq-option-editor.php?quizID=' . $quizID . '&mcqID=' . $mcqID);
            } else if ($update == -1) {
                $mcqID = $_POST['mcqID'];
                deleteMCQQuestion($conn, $mcqID);
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    if (isset($_GET['quizID'])) {
        $quizID = $_GET['quizID'];
        $quizResult = getMiscQuiz($conn, $quizID);
        $topicResult = getTopics($conn);
        $phpSelf = $pageName . '.php?quizID=' . $quizID;
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
<!--- Overlay the table-striped -->
<style>
    .table-striped > tbody > tr > .alert-danger,
    .table-striped > tbody > .alert-danger > td,
    .table-striped > tbody > .alert-danger > th {
        background-color: #f2dede !important;
    }
</style>

<div id="wrapper">
    <!-- Navigation Layout-->
    <?php require_once('navigation.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Misc Quiz Editor
                    <button type="button" class="btn btn-lg btn-info pull-right"
                            onclick="goBack()">GO BACK
                    </button>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">

                <!-- MetaData -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Quiz MetaData
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form id="metadata-submission" method="post" action="<?php echo $phpSelf; ?>">
                            <!--if 0 update; else if -1 delete;-->
                            <input type=hidden name="metadataUpdate" id="metadataUpdate" value="1" required>
                            <label for="QuizID" style="display:none">QuizID</label>
                            <input type="text" class="form-control" id="QuizID" name="QuizID" style="display:none"
                                   value="<?php echo $quizResult->QuizID; ?>">
                            <br>
                            <label for="Week">Week</label>
                            <input type="text" class="form-control" id="Week" name="Week"
                                   placeholder="Input Week Number" value="<?php echo $quizResult->Week; ?>">
                            <br>
                            <label for="QuizName">Quiz Name</label>
                            <input type="text" class="form-control" id="QuizName" name="QuizName"
                                   placeholder="Input Quiz Name" value="<?php echo $quizResult->QuizName; ?>">
                            <br>
                            <input type=hidden name="topicName" id="TopicName" value="Smoking" required>
                            <label for="Points">Points</label>
                            <input type="text" class="form-control" id="Points" name="Points" placeholder="Input Points"
                                   value="<?php echo $quizResult->Points; ?>">
                            <br>
                            <label for='ExtraQuiz'>Extra Quiz</label>
                            <select class="form-control" id="ExtraQuiz" form="metadata-submission" name="ExtraQuiz"
                                    required>
                                <option value="0" <?php if ($quizResult->ExtraQuiz == 0) echo 'selected';?> >No</option>
                                <option value="1" <?php if ($quizResult->ExtraQuiz == 1) echo 'selected';?> >Yes</option>
                            </select>
                            <br>
                        </form>
                        <!--edit metadata-->
                        <button type="button" class="btn btn-default btn-lg text-center pull-right" id="metadata-save">Save Changes</button>

                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Modal -->
<div class="modal fade" id="dialog" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="dialogTitle">Edit Question</h4>
            </div>
            <div class="modal-body">
                <form id="submission" method="post" action="<?php echo $phpSelf; ?>">
                    <input type=hidden name="update" id="update" value="1" required>
                    <label for="MCQID" style="display:none">MCQID</label>
                    <input type="text" class="form-control dialoginput" id="MCQID" name="mcqID" style="display:none">
                    <label for="Question">Question</label>
                    <input type="text" class="form-control dialoginput" id="Question" name="question" value="" required>
                    <br>
                    <label for="QuizID" style="display:none">QuizID</label>
                    <input type="text" class="form-control" id="QuizID" name="quizID" style="display:none"
                           value="<?php echo $quizID; ?>" required>
                    <br>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>
<!-- Page-Level Scripts -->
<script>
    //DO NOT put them in $(document).ready() since the table has multi pages
    var dialogInputArr = $('.dialoginput');
    $('.glyphicon-plus').on('click', function () {
        $("label").remove(".error");
        $('#dialogTitle').text("Add Question");
        $('#update').val(1);
        for (i = 0; i < dialogInputArr.length; i++) {
            dialogInputArr.eq(i).val('');
        }
    });

    $('div > .glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this quiz? If you remove one quiz. All the questions and submission of this quiz will also get deleted (not recoverable). It includes learning material, questions and options, their submissions and your grading/feedback, not only the quiz itself.')) {
            $('#metadataUpdate').val(-1);
            $('#metadata-submission').submit();
        }
    });
    $('td > .glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this Question?')){
            $('#update').val(-1);
            for (i = 0; i < dialogInputArr.length; i++) {
                dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
            }
            $('#submission').submit();
        }
    });
    $('#btnSave').on('click', function () {
        $('#submission').validate();
        $('#submission').submit();
    });

    $(document).ready(function () {
        var table = $('#datatables').DataTable({
            responsive: true,
            //rows group for Question and edit box
            rowsGroup: [1, 4],
            "pageLength": 100,
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [0]}
            ]
        });
        $('#metadata-save').on('click', function () {
            $('#metadataUpdate').val(0);
            $('#metadata-submission').validate({
                rules: {
                    week: {
                        required: true,
                        digits: true
                    },
                    points: {
                        required: true,
                        digits: true
                    },
                    QuizName: {
                        required: true
                    }
                }
            });
            $('#metadata-submission').submit();
        });
    });

    function goBack() {
        var week = document.getElementById("Week");
        var quizName = document.getElementById("QuizName");
        var extraQuiz = document.getElementById("ExtraQuiz");
        var weekIsChanged = week.value != week.defaultValue;
        var quizNameIsChanged = quizName.value != quizName.defaultValue;
        var extraQuizIsChanged = !extraQuiz.options[extraQuiz.selectedIndex].defaultSelected;
        if(weekIsChanged||extraQuizIsChanged || quizNameIsChanged){
            if(confirm("[Warning] You haven't save your changes, do you want to leave this page?")){
                location.href='<?php echo "misc.php" ?>'            }
        }else{
            location.href='<?php echo "misc.php" ?>'
        }
    }
</script>
<script src="researcher-tts.js"></script>
</body>

</html>
