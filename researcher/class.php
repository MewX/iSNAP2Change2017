<?php
session_start();
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
require_once('researcher-validation.php');

$columnName = array('ClassID', 'ClassName', 'SchoolName', 'TokenString', 'EnrolledStudents', 'UnlockedProgress', 'isClosed');

//if insert/update/remove class
try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            if ($update == 1) {
                $className = $_POST['className'];
                $schoolName = $_POST['schoolName'];
                $tokenString = $_POST['tokenString'];
                $unlockedProgress = $_POST['unlockedProgress'];
                $schoolID = getSchoolByName($conn, $schoolName)->SchoolID;
                $classID = createClass($conn, $schoolID, $className, $tokenString, $unlockedProgress);
            } else if ($update == 0) {
                $classID = $_POST['classID'];
                $className = $_POST['className'];
                $schoolName = $_POST['schoolName'];
                $tokenString = $_POST['tokenString'];
                $unlockedProgress = $_POST['unlockedProgress'];
                $schoolID = getSchoolByName($conn, $schoolName)->SchoolID;
                updateClass($conn, $classID, $schoolID, $className, $tokenString, $unlockedProgress);
            } else if ($update == -1) {
                $classID = $_POST['classID'];
                deleteClass($conn, $classID);
            } else if ($update == 2) {
                //close or open class
                $classID = $_POST['classID'];
                $isClosed = $_POST['isClosed'];
                setIsClosedForClass($conn, $classID, $isClosed);
                $response = array();
                $response['status'] = 'success';
                $response['message'] = 'This was successful';
                echo json_encode($response);
                exit();
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    $weekResult = getMaxWeek($conn);
    $schoolResult = getSchools($conn);
    $classResult = getClasses($conn);
    $studentNumResult = getStudentNum($conn);
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
                <h1 class="page-header">Class Overview</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Class Information Table <span class="glyphicon glyphicon-plus pull-right" data-toggle="modal"
                                                      data-target="#dialog"></span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="datatables">
                                <?php require_once('table-head.php'); ?>
                                <tbody>
                                <?php for ($i = 0; $i < count($classResult); $i++) { ?>
                                    <tr class="<?php if ($i % 2 == 0) {
                                        echo "odd";
                                    } else {
                                        echo "even";
                                    } ?>">
                                        <td style="display:none"><?php echo $classResult[$i]->ClassID ?></td>
                                        <td>
                                            <a href="student.php?classID=<?php echo $classResult[$i]->ClassID ?>"><?php echo $classResult[$i]->ClassName ?></a>
                                        </td>
                                        <td><?php echo $classResult[$i]->SchoolName ?></td>
                                        <td><?php echo $classResult[$i]->TokenString ?></td>
                                        <td><?php $count = 0;
                                            for ($j = 0; $j < count($studentNumResult); $j++) {
                                                if ($studentNumResult[$j]->ClassID == $classResult[$i]->ClassID) $count = $studentNumResult[$j]->Count;
                                            }
                                            echo $count; ?></td>
                                        <td>
                                            <?php echo min($classResult[$i]->UnlockedProgress, $weekResult->WeekNum) . "/" . $weekResult->WeekNum ?>
                                            <span class="glyphicon glyphicon-remove pull-right"
                                                  aria-hidden="true"></span><span class="pull-right" aria-hidden="true">&nbsp;
                                            </span>
                                            <span class="glyphicon glyphicon-edit pull-right" data-toggle="modal"
                                                  data-target="#dialog" aria-hidden="true">
                                            </span>
                                        </td>
                                        <td><?php
                                                if($classResult[$i]->isClosed == 0) {
                                            ?>
                                                <button type="button" class="btn btn-danger" onclick="setClass(<?php echo $classResult[$i]->ClassID?>, this)">Close this class</button>
                                            <?php
                                                } else{
                                            ?>
                                                <button type="button" class="btn btn-primary" onclick="setClass(<?php echo $classResult[$i]->ClassID?>, this)">Open this class</button>
                                            <?php
                                                } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <div class="well row">
                            <h4>Class Overview Notification</h4>
                            <div class="alert alert-info">
                                <p>View classes by filtering or searching. You can create/update/delete any class.</p>
                            </div>
                            <div class="alert alert-danger">
                                <p><strong>Warning</strong> : If you remove one class. All the <strong>student
                                        data</strong> in this class will also get deleted (not recoverable).</p> It
                                includes <strong>student information, their submissions of every task and your
                                    grading/feedback</strong>, not only the class itself.
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
                <h4 class="modal-title" id="dialogTitle">Edit Class</h4>
            </div>
            <div class="modal-body">
                <form id="submission" method="post"
                      action="<?php if (isset($_GET['schoolID'])) echo $_SERVER['PHP_SELF'] . '?schoolID=' . $_GET['schoolID']; else echo $_SERVER['PHP_SELF']; ?>">
                    <!--if 1, insert; else if 0 update; else if -1 delete;-->
                    <input type=hidden name="update" id="update" value="1" required>
                    <label for="ClassID" style="display:none">ClassID</label>
                    <input type="text" class="form-control dialogInput" id="ClassID" name="classID"
                           style="display:none">
                    <br><label for="ClassName">Class Name</label>
                    <input type="text" class="form-control dialogInput" id="ClassName" name="className" required>
                    <br><label for="SchoolName">School Name</label>
                    <select class="form-control dialogInput" id="SchoolName" form="submission" name="schoolName"
                            required>
                        <?php for ($i = 0; $i < count($schoolResult); $i++) { ?>
                            <option
                                value="<?php echo $schoolResult[$i]->SchoolName ?>"><?php echo $schoolResult[$i]->SchoolName ?></option>
                        <?php } ?>
                    </select>
                    <br><label for="tokenString">Token String (Unique)</label><span
                        class="glyphicon glyphicon-random pull-right"> Random</span>
                    <input type="text" class="form-control dialogInput" id="tokenString" name="tokenString" required>
                    <br>
                    <label for="EnrolledStudents">Enrolled Students</label>
                    <input type="text" class="form-control dialogInput" id="EnrolledStudents" name="enrolledStudents">
                    <br>
                    <label for="textInput" style="display:none"></label>
                    <input type="text" class="dialogInput pull-right" id="textInput" value="" disabled>
                    <label for="UnlockedProgress">UnlockedProgress</label>
                    <input type="range" class="dialogInput" min="0"
                           max="<?php echo $weekResult->WeekNum ?>"
                           id="UnlockedProgress" name="unlockedProgress" onchange="updateTextInput(this.value);">
                    <br><label for="SchoolName">Close this class</label>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<input type=hidden name="keyword" id="keyword" value="
      <?php
if (isset($_GET['schoolID'])) {
    try {
        $schoolID = $_GET['schoolID'];
        $schoolResult = getSchool($conn, $schoolID);
        echo $schoolResult->SchoolName;
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
    function randomString(length) {
        var text = "";
        var possible = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"; // optimzied for visualization
        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }

    function updateTextInput(val) {
        document.getElementById('textInput').value = val;
    }

    function setClass(classId, el){
        var classList = $(el).attr('class').split(/\s+/);
        if(classList[1] == 'btn-danger'){
            if(confirm('Are you sure that you want to close this class? Students in this class will not be able to log in' +
                    ' this website after you close this class. You can open this class after you close it.')){

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "class.php",
                    data: {
                        classID: classId,
                        update: 2,
                        isClosed: 1
                    }
                })
                    .done(function (feedback) {
                        $(el).addClass('btn-primary').removeClass('btn-danger');
                        $(el).text('Open this class');
                })
            }
        }else{
            if(confirm('Are you sure that you want to open this class? Students in this class be able to log in' +
                    ' this website after you open this class. You can close this class after you open it.')) {

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "class.php",
                    data: {
                        classID: classId,
                        update: 2,
                        isClosed: 0
                    }
                })
                    .done(function (feedback) {
                        $(el).addClass('btn-danger').removeClass('btn-primary');
                        $(el).text('Close this class');
                    })
            }
        }
    }

    //DO NOT put them in $(document).ready() since the table has multi pages

    var dialogInputArr = $('.dialogInput');
    var len = dialogInputArr.length;
    function showCurrentWeekInDialog(currentWeek) {
        dialogInputArr.eq(len - 2).val(currentWeek);
        dialogInputArr.eq(len - 1).val(currentWeek);
    }
    $('.glyphicon-edit').on('click', function () {
        $("label").remove(".error");
        $('#dialogTitle').text("Edit <?php echo $pageNameForView ?>");
        $('#update').val(0);
        for (i = 0; i < len - 2; i++) {
            dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
        }
        var currentWeek = $(this).parent().parent().children('td').eq(len - 2).text().trim().split("/")[0];
        showCurrentWeekInDialog(currentWeek);
        //disable ClassID, EnrolledStudents, UnlockedProgress
        dialogInputArr.eq(0).attr('disabled', 'disabled');
        dialogInputArr.eq(len - 3).attr('disabled', 'disabled');
    });
    $('.glyphicon-plus').on('click', function () {
        $("label").remove(".error");
        $('#dialogTitle').text("Add <?php echo $pageNameForView ?>");
        $('#update').val(1);
        for (i = 0; i < len; i++) {
            dialogInputArr.eq(i).val('');
        }
        showCurrentWeekInDialog(0);
        //disable ClassID, EnrolledStudents, UnlockedProgress
        dialogInputArr.eq(0).attr('disabled', 'disabled');
        dialogInputArr.eq(len - 3).attr('disabled', 'disabled');
    });
    $('.glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this class? All the student data in this class will also get deleted (not recoverable). It includes student information, their submissions of every task and your grading/feedback, not only the class itself.')) {
            $('#update').val(-1);
            //fill required input
            dialogInputArr.eq(0).prop('disabled', false);
            for (i = 0; i < dialogInputArr.length - 2; i++) {
                dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
            }
            var currentWeek = $(this).parent().parent().children('td').eq(len - 2).text().trim().split("/")[0];
            showCurrentWeekInDialog(currentWeek);
            $('#submission').submit();
        }
    });
    $('.glyphicon-random').on('click', function () {
        $('#tokenString').val(randomString(6));
    });
    $('#btnSave').on('click', function () {
        $('#submission').validate();
        dialogInputArr.eq(0).prop('disabled', false);
        $('#submission').submit();
    });

    $(document).ready(function () {
        var table = $('#datatables').DataTable({
            responsive: true,
            "initComplete": function (settings, json) {
                $('.input-sm').eq(1).val($("#keyword").val().trim());
            },
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [0]}
            ]
        });
        //search keyword, exact match
        table.search(
            $("#keyword").val().trim(), true, false, true
        ).draw();
    });
</script>
</body>

</html>
