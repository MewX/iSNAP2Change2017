<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");

try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['update']==1){//update timer
            $timer = $_POST['Timer'];
            $weekNum = $_POST['WeekNum'];
            setWeekTimer($conn, $weekNum, $timer);
        }else if($_POST['update']==-1){
            $week = $_POST['week'];
            $updateSql = removeWeek($conn, $week);
            //General error: 2014 Cannot execute queries while other unbuffered queries are active. Consider using PDOStatement::fetchAll().
            unset($updateSql);
            $response = array();
            $response['status'] = 'success';
            $response['message'] = 'This was successful';
            echo json_encode($response);
            exit();
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    $weekResult = getWeekTimer($conn);
    $weekNumResult = getMaxWeek($conn);
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
                <h1 class="page-header">Week Overview</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Week Information Table
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Week</th>
                                    <th>No. of Learning Activities</th>
                                    <th>Timer (Minutes)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                for ($i = 1; $i <= $weekNumResult->WeekNum; $i++) {
                                    $notEmpty = false;
                                    for ($j = 0; $j < count($weekResult); $j++) {
                                        if ($weekResult[$j]->Week == $i) { ?>
                                            <tr class="<?php if (($i - 1) % 2 == 0) {
                                                echo "odd";
                                            } else {
                                                echo "even";
                                            } ?>">
                                                <td>
                                                    <a id="<?php echo $i; ?>"
                                                       href="quiz.php?week=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </td>
                                                <td>
                                                    <?php echo $weekResult[$j]->QuizNum==null? 0:$weekResult[$j]->QuizNum; ?>
                                                </td>
                                                <td>
                                                    <?php echo $weekResult[$j]->Timer==null? 0:$weekResult[$j]->Timer; ?>
                                                    <span class="glyphicon glyphicon-remove pull-right" aria-hidden="true"
                                                            data-toggle="modal" data-target="#dialog"> </span>
                                                    <span class="glyphicon glyphicon-edit pull-right" aria-hidden="true"
                                                          data-toggle="modal" data-target="#dialog-edit"> </span>
                                                </td>
                                            </tr>
                                            <?php $notEmpty = true;
                                        }
                                    }
                                    if (!$notEmpty) { ?>
                                        <tr class="<?php if (($i - 1) % 2 == 0) {
                                            echo "odd";
                                        } else {
                                            echo "even";
                                        } ?>">
                                            <td><a id="<?php echo $i; ?>"
                                                   href="quiz.php?week=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </td>
                                            <td><?php echo 0; ?></td>
                                            <td><?php echo 0; ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <div class="well row">
                            <h4>School Overview Notification</h4>
                            <div class="alert alert-info">
                                <p>View weeks by filtering or searching. You can create/delete any week.</p>
                            </div>
                            <div class="alert alert-warning">
                                <p>If you need to add another week, you can either add it on this page or go to <a href="quiz.php">Quiz Overview</a>
                                    with the week number you wish to add.</p>
                            </div>
                            <div class="alert alert-danger">
                                <p><strong>Reminder</strong>: If you remove one week, all the quizzes linked to this week will still exist,
                                    but they will not be assigned to a week number. If you would like to assign these quizzes to another week,
                                    you should assign them to another week via <a href="quiz.php">Quiz Overview</a>.</p>
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

<!-- /#wrapper for edit -->
<div class="modal fade" id="dialog-edit" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="dialogTitle">Edit Timer</h4>
            </div>
            <div class="modal-body">
                <form id="submission-timer" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type=hidden name="update" id="update" value="1" required>
                    <input type=hidden name="WeekNum" class="dialoginput-timer" id="WeekNum" value="" required>
                    <label for="Timer" style="display:none">Timer</label>
                    <input type="text" class="form-control dialoginput-timer" id="Timer" name="Timer"
                           placeholder="Minutes">
                    <br>
                </form>
            </div>
            <div class="alert alert-info">
                <p><strong>Reminder</strong>: You can set the duration (minutes) for quiz in one week at here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnConfirm-timer" class="btn btn-default">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>
<!-- Page-Level Scripts -->
<script>
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true,
            "pageLength": 25
        });
    });
    var dialogInputArr = $('.dialoginput');
    $('.glyphicon-remove').on('click', function () {
        if(confirm("[Warning] Are you sure to remove this week?" +
                "If you remove one week, all the quizzes linked to this week will still exist, " +
                "but you should assign them to another week if you need.")){
            week = $(this).parent().parent().children('td').eq(0).children('a').attr('id');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "week.php",
                data: {
                    week: week,
                    update: -1
                }
            })
                .done(function(feedback) {
                //$('#'+commentID).remove();
                location.reload();
            })
        }
    });
    $('.glyphicon-edit').on('click', function () {
        $('.dialoginput-timer').eq(0).val($(this).parent().parent().children('td').eq(0).children('a').attr("id"));
        $('.dialoginput-timer').eq(1).val($(this).parent().parent().children('td').eq(2).text().trim());
    });
    $('#btnConfirm-timer').on('click', function () {
        console.log("clicked");
        $('#submission-timer').validate({
            rules: {
                Timer: {
                    required: true,
                    digits: true
                }
            }
        });
        $('#submission-timer').submit();
    });
</script>
</body>

</html>
