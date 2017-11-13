<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$parentPage = 'Location: ' . SAQ_LIKE_QUIZ_TYPE . '.php';
$columnName = array('SAQID', 'Question', 'Points', 'Edit');

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
                    $quizName = $_POST['QuizName'];
                    $conn->beginTransaction();
                    $extraQuiz = $_POST['ExtraQuiz'];
                    $topicID = getTopicByName($conn, $topicName)->TopicID;
                    updateQuiz($conn, $quizID, $quizName, $topicID, $week, $extraQuiz);

                    if (isset($_POST['mediaTitle']) && isset($_POST['mediaSource'])) {
                        $mediaTitle = $_POST['mediaTitle'];
                        $mediaSource = $_POST['mediaSource'];
                        updateSAQLikeSection($conn, $quizID, $mediaSource, $mediaTitle);
                    }

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
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            if ($update == 1) {
                $quizID = $_POST['quizID'];
                $points = $_POST['points'];
                $question = $_POST['question'];
                createSAQQuestion($conn, $quizID, $points, $question);
            } else if ($update == 0) {
                $saqID = $_POST['saqID'];
                $points = $_POST['points'];
                $question = $_POST['question'];
                updateSAQQuestion($conn, $saqID, $points, $question);
            } else if ($update == -1) {
                $saqID = $_POST['saqID'];
                deleteSAQQuestion($conn, $saqID);
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    if (isset($_GET['quizID'])) {
        $quizID = $_GET['quizID'];
        $quizResult = getSAQQuiz($conn, $quizID);
        $topicResult = getTopics($conn);
        $materialRes = getLearningMaterial($conn, $quizID);
        $saqQuesResult = getSAQQuestions($conn, $quizID);
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
                        <form id="metadata-submission" method="post" action="<?php echo $phpSelf; ?>" name="quizEditor">
                            <!--if 0 update; else if -1 delete;-->
                            <input type=hidden name="metadataUpdate" id="metadataUpdate" value="1" required>
                            <label for="QuizID" style="display:none">QuizID</label>
                            <input type="text" class="form-control" id="QuizID" name="quizID" style="display:none"
                                   value="<?php echo $quizResult->QuizID; ?>">
                            <br>
                            <label for="Week">Week</label>
                            <input type="text" class="form-control" id="Week" name="week"
                                   placeholder="Input Week Number" value="<?php echo $quizResult->Week; ?>">
                            <br>
                            <label for="QuizName">Quiz Name</label>
                            <input type="text" class="form-control" id="QuizName" name="QuizName"
                                   placeholder="Input Quiz Name" value="<?php echo $quizResult->QuizName; ?>">
                            <br>
                            <input type=hidden name="topicName" id="TopicName" value="Smoking" required>
                            <label for='ExtraQuiz'>Extra Quiz</label>
                            <select class="form-control" id="ExtraQuiz" form="metadata-submission" name="ExtraQuiz"
                                    required>
                                <option value="0" <?php if ($quizResult->ExtraQuiz == 0) echo 'selected';?> >No</option>
                                <option value="1" <?php if ($quizResult->ExtraQuiz == 1) echo 'selected';?> >Yes</option>
                            </select>

                            <br>
                            <?php if (SAQ_LIKE_QUIZ_TYPE != 'saq') { ?>
                                <label for="mediaTitle"><?php echo ucfirst(SAQ_LIKE_QUIZ_TYPE) ?> Title</label>
                                <input type="text" class="form-control" id="mediaTitle" name="mediaTitle"
                                       placeholder="Input <?php echo ucfirst(SAQ_LIKE_QUIZ_TYPE) ?> Title"
                                       value="<?php echo $quizResult->MediaTitle; ?>"
                                       required>
                                <br>
                                <label for="mediaSource"><?php echo ucfirst(SAQ_LIKE_QUIZ_TYPE) ?> Source</label>
                                <input type="text" class="form-control" id="mediaSource" name="mediaSource"
                                       placeholder="Input <?php echo ucfirst(SAQ_LIKE_QUIZ_TYPE) ?> Source"
                                       value="<?php echo $quizResult->MediaSource; ?>"
                                       required>
                                <br>
                                <?php if (strlen($quizResult->MediaTitle) == 0 || strlen($quizResult->MediaSource) == 0) { ?>
                                    <div class="alert alert-danger">
                                        <p><strong>Reminder</strong> : You have not
                                            added <?php echo SAQ_LIKE_QUIZ_TYPE ?> title
                                            or <?php echo SAQ_LIKE_QUIZ_TYPE ?> source!
                                    </div>
                                <?php } ?>
                            <?php } ?>

                            <label for="Points">Points</label>
                            <input type="text" class="form-control" id="Points" name="points" placeholder="0"
                                   value="<?php echo $quizResult->Points; ?>" disabled>
                            <br>
                            <label for="Questions">Questions</label>
                            <input type="text" class="form-control" id="Questions" name="questions"
                                   value="<?php echo $quizResult->Questions; ?>" disabled>
                            <br>
                        </form>
                        <!--edit metadata-->
                        <button type="button" class="btn btn-default btn-lg text-center pull-right" id="metadata-save">Save Changes</button>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

                <?php require_once('learning-material-editor-iframe.php'); ?>

                <!-- Questions -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Questions and Points
                        <span class="glyphicon glyphicon-plus pull-right" data-toggle="modal"
                              data-target="#dialog"></span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="datatables">
                                <?php require_once('table-head.php'); ?>
                                <tbody>
                                <?php for ($i = 0; $i < count($saqQuesResult); $i++) { ?>
                                    <tr class="<?php if ($i % 2 == 0) {
                                        echo "odd";
                                    } else {
                                        echo "even";
                                    } ?>">
                                        <td style="display:none"><?php echo $saqQuesResult[$i]->$columnName[0]; ?></td>
                                        <td><?php echo $saqQuesResult[$i]->$columnName[1] ?></td>
                                        <td><?php echo $saqQuesResult[$i]->$columnName[2] ?></td>
                                        <td>
                                            <span class="glyphicon glyphicon-remove pull-right "
                                                  aria-hidden="true"></span>
                                            <span class="pull-right" aria-hidden="true">&nbsp;</span>
                                            <span class="glyphicon glyphicon-edit pull-right" data-toggle="modal"
                                                  data-target="#dialog" aria-hidden="true"></span>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <div class="well row">
                            <h4><?php echo $pageNameForView; ?> Notification</h4>
                            <div class="alert alert-info">
                                <p>View questions in this quiz by filtering or searching. You can
                                    create/update/delete any question.</p>
                            </div>
                            <div class="alert alert-danger">
                                <p><strong>Warning</strong> : If you remove one question. All the <strong>student
                                        answers</strong> of this question will also get deleted (not recoverable), not
                                    only the question itself.</p>
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
<!-- Modal -->
<div class="modal fade" id="dialog" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="dialogTitleSAQ"></h4>
            </div>
            <div class="modal-body">
                <form id="submission" method="post" action="<?php echo $phpSelf; ?>">
                    <input type=hidden name="update" id="update" value="1" required>
                    <label for="SAQID" style="display:none">SAQID</label>
                    <input type="text" class="form-control dialoginput" id="SAQID" name="saqID" style="display:none">
                    <label for="Question">Question</label>
                    <input type="text" class="form-control dialoginput" id="Question" name="question"
                           placeholder="Input Question" value="" required>
                    <br>
                    <label for="Points">Points</label>
                    <input type="text" class="form-control dialoginput" id="Points" name="points"
                           placeholder="Input Points" value="" required>
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
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    //DO NOT put them in $(document).ready() since the table has multi pages
    var dialogInputArr = $('.dialoginput');
    $('.glyphicon-plus').on('click', function () {
        $("label").remove(".error");
        $('#dialogTitleSAQ').text("Add Question");
        $('#update').val(1);
        for (i = 0; i < dialogInputArr.length; i++) {
            dialogInputArr.eq(i).val('');
        }
    });
    $('div > .glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this quiz? If you remove one quiz. All the questions and submission of this quiz will also get deleted (not recoverable). It includes learning material, questions, their submissions and your grading/feedback, not only the quiz itself.')) {
            $('#metadataUpdate').val(-1);
            $('#metadata-submission').submit();
        }
    });
    $('td > .glyphicon-edit').on('click', function () {
        $('#dialogTitleSAQ').text("Edit Question");
        $('#update').val(0);
        for (i = 0; i < dialogInputArr.length; i++) {
            dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
        }
    });
    $('td > .glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this Question?')) {
            $('#update').val(-1);
            for (i = 0; i < dialogInputArr.length; i++) {
                dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
            }
            $('#submission').submit();
        }
    });
    $('#btnSave').on('click', function () {
        $('#submission').validate({
            rules: {
                points: {
                    required: true,
                    digits: true
                }
            }
        });
        $('#submission').submit();
    });

    $(document).ready(function () {
        var table = $('#datatables').DataTable({
            responsive: true,
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
                    }
                }
            });
            var form = document.forms.quizEditor;
            var postData = [];
            for(var i=0; i<form.elements.length; i++){
                postData.push(form.elements[i].name + "=" + form.elements[i].value);
            }
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "mcq-editor.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(postData.join("&"));
            $("#learning-material-editor").contents().find("#learningMaterial").submit();
            location.reload();
        });
    });

    function goBack() {
        var week = document.getElementById("Week");
        var quizName = document.getElementById("QuizName");
        var extraQuiz = document.getElementById("ExtraQuiz");
        var mediaTitle = document.getElementById("mediaTitle");
        var mediaSource = document.getElementById("mediaSource");
        var weekIsChanged = week.value != week.defaultValue;
        var quizNameIsChanged = quizName.value != quizName.defaultValue;
        var extraQuizIsChanged = !extraQuiz.options[extraQuiz.selectedIndex].defaultSelected;
        var original = atob("<?echo base64_encode(str_replace(array("\n\r", "\n", "\r"), '',$materialRes->Content))?>");
        //TODO:
        //检测tinymce编辑器里的内容是否有变化
        //可能的case：
        //1. 通过 isDirty() 这个方法检测内容是否被改动 （http://archive.tinymce.com/wiki.php/API3:method.tinymce.Editor.isDirty），问题在于在这个页面拿不到editor
        //2. 通过拿到form里的value来和初始数据做比较，问题在于form里的value没有根据编辑器里的内容变化而变化
        //3. 通过拿到编辑器里的内容来和初始数据做比较，问题在于编辑器里的内容会给视频或者链接加tag。链接tag可以用正则解决，视频的有点麻烦。。

        //case 1 的代码
        //tinymce是在learning-material-editor声明的，我从这里拿不到
//        if (tinymce.activeEditor.isDirty())//is null
//            alert("You must save your contents.");

        //case 2 的代码
        //var case2 = document.getElementById('learning-material-editor').contentWindow.document.getElementsByName('richContentTextArea')[0].value;
        //console.log(case2);

        //case 3 的代码
        //拿到tinymce编辑器里的内容
        var materialContent = document.getElementById('learning-material-editor').contentWindow.document.getElementById('materialContent_ifr')
            .contentWindow.document.getElementById('tinymce');
        //通过正则处理多余的tag，可以处理链接，但是处理不了视频， 因为视频的tag改动好复杂，而且用正则也不是太稳定，总会有一些我们没考虑到的情况
        tempMaterial = materialContent.innerHTML;
        tempMaterial = tempMaterial.replace(/.data-mce-href=\".*\"/,"");
        var materialContentIsChanged = tempMaterial != original;

        console.log(original);

        if(mediaTitle!=null && mediaSource!=null){
            var mediaTitleIsChanged = mediaTitle.value != mediaTitle.defaultValue;
            var mediaSourceIsChanged = mediaSource.value != mediaSource.defaultValue;
            if(weekIsChanged||extraQuizIsChanged||mediaTitleIsChanged || mediaSourceIsChanged || quizNameIsChanged || materialContentIsChanged){
                if(confirm("[Warning] You haven't save your changes, do you want to leave this page?")){
                    location.href='<?php echo SAQ_LIKE_QUIZ_TYPE . ".php" ?>'
                }
            }else{
                location.href='<?php echo SAQ_LIKE_QUIZ_TYPE . ".php" ?>'
            }
        }else{
            if(weekIsChanged||extraQuizIsChanged ||quizNameIsChanged || materialContentIsChanged){
                if(confirm("[Warning] You haven't save your changes, do you want to leave this page?")){
                    location.href='<?php echo SAQ_LIKE_QUIZ_TYPE . ".php" ?>'
                }
            }else{
                location.href='<?php echo SAQ_LIKE_QUIZ_TYPE . ".php" ?>'
            }
        }
    }
</script>
<script src="researcher-tts.js"></script>
</body>

</html>
