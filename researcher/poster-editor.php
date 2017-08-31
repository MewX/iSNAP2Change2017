<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$parentPage = 'Location: poster.php';

try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['metadataUpdate'])) {
            $metadataUpdate = $_POST['metadataUpdate'];
            if ($metadataUpdate == 0) {
                try {
                    $quizID = $_POST['quizID'];
                    $week = $_POST['week'];
                    $topicName = $_POST['topicName'];
                    $points = $_POST['points'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $extraQuiz = $_POST['ExtraQuiz'];
                    $conn->beginTransaction();

                    $topicID = getTopicByName($conn, $topicName)->TopicID;
                    updateQuiz($conn, $quizID, $topicID, $week, $extraQuiz);
                    updatePosterSection($conn, $quizID, $description, $points, $title);

                    $conn->commit();
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
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    if (isset($_GET['quizID'])) {
        $quizID = $_GET['quizID'];
        $quizResult = getPosterQuiz($conn, $quizID);
        $topicResult = getTopics($conn);
        $materialRes = getLearningMaterial($conn, $quizID);
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

<div id="wrapper">
    <!-- Navigation Layout-->
    <?php require_once('navigation.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $pageNameForView; ?> Editor
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
                            <label for="quizID" style="display:none">QuizID</label>
                            <input type="text" class="form-control" id="quizID" name="quizID" style="display:none"
                                   value="<?php echo $quizResult->QuizID; ?>">
                            <br>
                            <label for="week">Week</label>
                            <input type="text" class="form-control" id="week" name="week"
                                   placeholder="Input Week Number" value="<?php echo $quizResult->Week; ?>">
                            <br>
                            <label for='TopicName'>TopicName</label>
                            <select class="form-control" id="TopicName" form="metadata-submission" name="topicName"
                                    required>
                                <?php for ($j = 0; $j < count($topicResult); $j++) { ?>
                                    <option
                                        value='<?php echo $topicResult[$j]->TopicName ?>'
                                        <?php if ($topicResult[$j]->TopicName == $quizResult->TopicName) echo 'selected' ?>
                                    >
                                        <?php echo $topicResult[$j]->TopicName ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <br>

                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Input Title"
                                   value="<?php echo $quizResult->Title; ?>"
                                   required>
                            <br>
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                      placeholder="Input Description"
                                      rows="8"
                                      required><?php echo $quizResult->Description; ?>
                                </textarea>
                            <br>
                            <?php if (strlen($quizResult->Title) == 0 || strlen($quizResult->Description) == 0) { ?>
                                <div class="alert alert-danger">
                                    <p><strong>Reminder</strong> : You have not added title or description!
                                </div>
                            <?php } ?>
                            <label for='ExtraQuiz'>Extra Quiz</label>
                            <select class="form-control" id="ExtraQuiz" form="metadata-submission" name="ExtraQuiz"
                                    required>
                                <option value="0" <?php if ($quizResult->ExtraQuiz == 0) echo 'selected';?> >No</option>
                                <option value="1" <?php if ($quizResult->ExtraQuiz == 1) echo 'selected';?> >Yes</option>
                            </select>
                            <br>
                            <label for="points">Points</label>
                            <input type="text" class="form-control" id="points" name="points" placeholder="0"
                                   value="<?php echo $quizResult->Points; ?>" required>
                            <br>
                        </form>
                        <!--edit metadata-->
                        <button type="button" class="btn btn-default btn-lg text-center pull-right" id="metadata-save">Save Changes</button>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

                <?php require_once('learning-material-editor-iframe.php'); ?>

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
    //DO NOT put them in $(document).ready() since the table has multi pages
    $('div > .glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this quiz? If you remove one quiz. All the questions and submission of this quiz will also get deleted (not recoverable). It includes learning material, questions, their submissions and your grading/feedback, not only the quiz itself.')) {
            $('#metadataUpdate').val(-1);
            $('#metadata-submission').submit();
        }
    });
    $(document).ready(function () {
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
                    }
                }
            });
            $('#metadata-submission').submit();
        });
    });
    function goBack() {
        var week = document.getElementById("week");
        var topicName = document.getElementById("TopicName");
        var title = document.getElementById("title");
        var discription = document.getElementById("description");
        var extraQuiz = document.getElementById("ExtraQuiz");
        var points = document.getElementById("points");
        var titleIsChanged = title.value != title.defaultValue;
        var weekIsChanged = week.value != week.defaultValue;
        var discriptionIsChanged = discription.value != discription.defaultValue;
        var pointsIsChanged = points.value != points.defaultValue;
        var topicNameIsChanged = !topicName.options[topicName.selectedIndex].defaultSelected;
        var extraQuizIsChanged = !extraQuiz.options[extraQuiz.selectedIndex].defaultSelected;
        if(weekIsChanged||topicNameIsChanged||extraQuizIsChanged || discriptionIsChanged || pointsIsChanged || titleIsChanged){
            if(confirm("[Warning] You haven't save your changes, do you want to leave this page?")){
                location.href='<?php echo "poster.php" ?>'
            }
        }else{
            location.href='<?php echo "poster.php" ?>'
        }
    }
</script>
</body>
</html>
