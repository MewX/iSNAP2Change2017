<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");

if (isset($_GET['quizID'])) {
    $quizID = $_GET['quizID'];
    $studentID = $_GET['StudentID'];
}

try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            if ($update == 0) {
                $studentID = $_POST['studentID'];
                $grading = $_POST['grading'];
                updatePosterGrading($conn, $quizID, $studentID, $grading);
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    $posterSubmissionResult = getPosterSubmissionsByQuiz($conn, $quizID, $studentID);
    $materialRes = getLearningMaterial($conn, $quizID);
    $phpSelf = $pageName . '.php?quizID=' . $quizID . '&StudentID=' .$studentID;
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
                <h1 class="page-header">Poster Grader</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">

                <?php require_once('learning-material.php'); ?>

                <!-- Questions -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Student Submission
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="parent-container">
                            <!-- Grader -->
                            <form id="submission" method="post" action="<?php echo $phpSelf ?>"
                                  style="text-align: center;">
                                <input type=hidden name="update" id="update" value="0" required>
                                <input type=hidden name="quizID" value="<?php echo $quizID ?>" required>
                                <input type=hidden name="studentID"
                                       value="<?php echo $posterSubmissionResult[0]->StudentID ?>">
                                <input type=hidden name="totalPoints" id="totalPoints"
                                       value="<?php echo $posterSubmissionResult[0]->Points ?>">
                                <br>
                                <a href="<?php echo $posterSubmissionResult[0]->ImageURL ?>"><img
                                        src="<?php echo $posterSubmissionResult[0]->ImageURL ?>"
                                        alt="Failed to load poster. Please contact developers."
                                        width="50%"
                                        height="auto"/></a>
                                <br>
                                <br>
                                <label for="grading">Grading</label>
                                <p id="errorMessage" style="color: red"></p>
                                <input type="text"
                                       id="grading" name="grading"
                                       value="<?php echo $posterSubmissionResult[0]->Grading ?>"
                                >
                                <label>out of <?php echo $posterSubmissionResult[0]->Points?></label>
                                <br>
                            </form>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                    <div class="panel-footer text-center">
                        <button type="button" id="btnSave" class="btn btn-default btn-info">Save</button>
                    </div>
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

<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>
<!-- Page-Level Scripts -->
<script>
    function updateTextInput(quizID, val) {
        document.getElementById('textInput' + quizID).value = val;
    }

    $(document).ready(function () {
        $('#btnSave').on('click', function () {
            var totalPoints = $('#totalPoints').val();
            $('#submission').validate({
                rules: {
                    grading: {
                        required: true,
                        range: [0, totalPoints]
                    }
                },
                errorLabelContainer: "#errorMessage"
            });

            $('#submission').submit();
        });

        $('.parent-container').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image',
            // other options
            gallery: {
                enabled: true, // set to true to enable gallery
                navigateByImgClick: true,
                arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button
                tPrev: 'Previous (Left arrow key)', // title for left button
                tNext: 'Next (Right arrow key)', // title for right button
                tCounter: '<span class="mfp-counter">%curr% of %total%</span>' // markup of counter
            }
        })
    });
</script>
</body>

</html>
