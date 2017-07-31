<?php
session_start();
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$columnName = array('ClassName', 'FirstName', 'LastName');
$colspanName = array('');
$quizList = array('ClassName', 'FirstName', 'LastName');
try {
    $conn = db_connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            //reset student password
            if ($update == 0) {
                $studentID = $_POST['studentID'];
                //resetPassword($conn, $studentID);
            } //delete student (with help of DELETE CASCADE)
            else if ($update == -1) {
                $studentID = $_POST['StudentID'];
                $quizID = $_POST['QuizID'];
                echo "<script>console.log( 'StuID: " . $studentID . "' );</script>";
                echo "<script>console.log( 'QuizID: " . $quizID . "' );</script>";
                resetStuDueTime($conn,$studentID,$quizID);
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    refreshAllStudentsScore($conn);
    $getQuizWithWeek = getQuizWithWeek($conn);
    $getQuizInfo = getQuizInfo($conn);
    $studentStatistic = getStudentsStatistic($conn);
    for ($i = 0; $i < count($getQuizWithWeek); $i++){
        $j = $i+1;
        array_push($colspanName, "Week$j");
    }
    for ($i = 1; $i <= count($getQuizInfo); $i++){
        array_push($columnName,"Quiz$i");
    }
    for ($i = 0; $i < count($getQuizInfo); $i++){
        $j = $getQuizInfo[$i]->QuizID;
        echo "<script>console.log( 'QuizID: " . $j . "' );</script>";
        array_push($quizList,"Quiz$j");
    }
} catch (Exception $e) {
    debug_err($e);
}

db_close($conn);

?>
<!DOCTYPE html>
<html lang="en">

<style>
    .fa-clock-o:hover {
        color: grey;
    }
</style>


<!-- Header Library -->
<?php require_once('header-lib.php'); ?>

<body>

<div id="wrapper">
    <!-- Navigation Layout-->
    <?php require_once('navigation.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Statistic Overview</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Student Statistic Table
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div>
                            Toggle column:
                            <?php for ($i = 0; $i < count($columnName); $i++) {?>
                                    <i class="fa fa-check-square-o fa-fw"></i><a class="toggle-vis"
                                                                                 start = "2" data-column="<?php echo $i; ?>"><?php echo $columnName[$i]; ?></a>&nbsp;
                            <?php } ?>
                            <br>
                            <br>
                                <span class="fa fa fa-certificate pull-left" aria-hidden="true" style="font-size: 16px"> Graded</span>
                                <span class="fa fa-star pull-left" aria-hidden="true" style="font-size: 16px"> Not Graded</span>
                                <span class="fa fa-star-o pull-left" aria-hidden="true" style="font-size: 16px"> Not Submitted</span>
                                <span class="fa fa-clock-o pull-left" aria-hidden="true" style="font-size: 16px"> Reset Timer </span>
                            <br>
                            <br>
                        </div>

                        <div class="dataTable_wrapper">

                            <table class="table table-striped table-bordered table-hover" id="datatables">

                                <thead>
                                    <tr>
                                        <?php for ($i = 0; $i< count($colspanName); $i++){?>
                                            <th colspan= <?php if( $i!=0 ) echo $getQuizWithWeek[$i-1]->QuizNum; else echo 3?> >
                                                Week<?php if( $i!=0 ) echo $getQuizWithWeek[$i-1]->Week?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php for ($i = 0; $i < count($columnName); $i++) { ?>
                                            <?php if($i>2):?>
                                                <th QuizID= <?php echo $getQuizInfo[$i-3]->QuizID;?> ><?php echo $columnName[$i]?>
                                            <?php else: ?>
                                                <th><?php echo $columnName[$i]?>
                                            <?php endif ?>
                                            <?php
                                                if ($i > 2) {
                                                    echo '<span class="glyphicon glyphicon-time pull-right" aria-hidden="true"></span>';
                                                }
                                            ?>
                                                </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php for ($i = 0; $i < count($studentStatistic); $i++) { ?>
                                    <tr class="<?php if ($i % 2 == 0) {
                                        echo "odd";
                                    } else {
                                        echo "even";
                                    } ?>">
                                        <?php for ($j = 0; $j < count($quizList); $j++) { ?>

                                            <td>
                                                <?php
                                                    if($studentStatistic[$i]->$quizList[$j] == "GRADED")
                                                        echo '<span class="fa fa fa-certificate pull-left" aria-hidden="true"></span>';
                                                    else if($studentStatistic[$i]->$quizList[$j] == "UNGRADED")
                                                        echo '<span class="fa fa-star pull-left" aria-hidden="true"></span>';
                                                    else if($studentStatistic[$i]->$quizList[$j] == "UNSUBMITTED" || $studentStatistic[$i]->$quizList[$j]=="")
                                                        echo '<span class="fa fa-star-o pull-left" aria-hidden="true"></span>';
                                                    else
                                                        echo $studentStatistic[$i]->$quizList[$j];
                                                    if ($j > 2) {
                                                        echo '<span class="glyphicon glyphicon-time pull-right" aria-hidden="true"></span>';
                                                    }
                                                ?>
                                                <span id = "StudentID" class="invisible"> <?php echo $studentStatistic[$i]->StudentID; ?> </span>
                                                <span id = "QuizID" class = "invisible"> <?php if($j >2) echo substr($quizList[$j],4); ?> </span>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <div class="well row">
                            <h4>Student Overview Notification</h4>
                            <div class="alert alert-info">
                                <p>View students by filtering or searching. You can <strong>reset student
                                        password</strong> or delete students.</p>
                            </div>
                            <div class="alert alert-danger">
                                <p><strong>Reminder</strong> : If you remove one student. All the data of this student
                                    will also get deleted (not recoverable). It includes <strong>student submissions of
                                        every task and your grading/feedback</strong>, not only the student itself.</p>
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
            </div>
            <div class="modal-body">
                <form id="submission" method="post"
                      action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!--if 0 update; else if -1 delete;-->
                    <input type=hidden name="update" id="update" value="1">
                    <input type=hidden name="StudentID" class="form-control dialoginput" id="Student" value="2">
                    <input type=hidden name="QuizID" class="form-control dialoginput" id="Quiz" value="3">
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<input type=hidden name="keyword" id="keyword" value="
      <?php
if (isset($_GET['classID'])) {
    // get ClassName
    try {
        $classID = $_GET['classID'];
        $classResult = getClass($conn, $classID);
        echo $classResult->ClassName;
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
        return Math.round((Math.pow(36, length + 1) - Math.random() * Math.pow(36, length))).toString(36).slice(1);
    }
    //DO NOT put them in $(document).ready() since the table has multi pages
    var dialogInputArr = $('.dialoginput');
    $('.glyphicon-time').on('click', function () {
        $('#update').val(-1);
        var StudentID = $(this).parent().children('#StudentID').text();
        var QuizID = $(this).parent().children('#QuizID').text();
        console.log("stu: " + StudentID + " Quiz: " + QuizID);
        dialogInputArr.eq(0).val(StudentID);
        dialogInputArr.eq(1).val(QuizID);
        //enable all the input
        dialogInputArr.each(function () {
            $(this).prop('disabled', false);
        });
        $('#submission').submit();

    });


    $(document).ready(function () {
        $('#datatables').css('width', '100%');
        var table = $('#datatables').DataTable({
            responsive: true,
            "initComplete": function (settings, json) {
                $('.input-sm').eq(1).val($("#keyword").val().trim());
                //this.style.width = 100% ;
            },
            "pageLength": 50
        });
        //search keyword, exact match
        table.search(
            $("#keyword").val().trim(), true, false, true
        ).draw();


        //Toggle column visibility
        $('a.toggle-vis').on('click', function (e) {
            e.preventDefault();
            // Get the column API object
            var column = table.column($(this).attr('data-column'));
            column.visible(!column.visible());
            var checkbox = $(this).parent().children().eq($(this).index() - 1);
            if (checkbox.hasClass('fa-check-square-o'))
                checkbox.removeClass('fa-check-square-o').addClass('fa-square-o');
            else if (checkbox.hasClass('fa-square-o'))
                checkbox.removeClass('fa-square-o').addClass('fa-check-square-o');
        });

        $('.fa-square-o, .fa-check-square-o').on('click', function (e) {
            $(this).parent().children().eq($(this).index() + 1).click();
        });
        var hiddenColArray = [];
        //hide week results by default
        var numOfQuiz = <?php echo count($quizResult);?>;
        for (i = 1; i<=numOfQuiz; i++){
            hiddenColArray.push("Quiz"+i);
        }

        $('a.toggle-vis').each(function () {
            if (jQuery.inArray($(this).text(), hiddenColArray) != -1)
                $(this).click();
        });
    });
</script>
</body>

</html>
