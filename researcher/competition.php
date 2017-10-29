<?php
session_start();
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$columnName = array('CompetitionID', 'DueWeek', 'Title');


try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            if ($update == 1) {
                $dueWeek = $_POST['DueWeek'];
                $title = $_POST['Title'];
                createCompetition($conn, $dueWeek, $title);
            }else if ($update == -1) {
                $competitionID = $_POST['CompetitionID'];
                deleteCompetition($conn, $competitionID);
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}


try {
    $competitionResult = getCompetitions($conn);
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
                        Competition Information Table <span class="glyphicon glyphicon-plus pull-right" data-toggle="modal"
                                                     data-target="#dialog"></span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="datatables">
                                <?php require_once('table-head.php'); ?>
                                <tbody>
                                <?php for ($i = 0; $i < count($competitionResult); $i++) {
                                    $competitionID = $competitionResult[$i]->CompetitionID;
                                    ?>
                                    <tr class="<?php if ($i % 2 == 0) {
                                        echo "odd";
                                    } else {
                                        echo "even";
                                    } ?>">
                                        <td style="display:none"><?php echo $competitionID ?></td>
                                        <td><?php echo $competitionResult[$i]->DueWeek ?></td>
                                        <td><?php echo $competitionResult[$i]->Title ?>
                                            <span class="glyphicon glyphicon-remove pull-right"
                                                  aria-hidden="true"></span>
                                            <span class="pull-right" aria-hidden="true">&nbsp;</span>
                                            <a href="competition-editor.php?competitionID=<?php echo $competitionID ?>">
                                                <span class="glyphicon glyphicon-edit pull-right"
                                                      aria-hidden="true"></span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
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
                <h4 class="modal-title" id="dialogTitle"></h4>
            </div>
            <div class="modal-body">
                <form id="submission" method="post"
                      action="<?php if (isset($_GET['week'])) echo $_SERVER['PHP_SELF'] . '?week=' . $_GET['week']; else echo $_SERVER['PHP_SELF']; ?>">
                    <!--if 1, insert; else if -1 delete;-->
                    <input type=hidden name="update" id="update" value="1" required>
                    <label for="CompetitionID" style="display:none">Competition ID</label>
                    <input type="text" class="form-control dialoginput" id="CompetitionID" name="CompetitionID" style="display:none">
                    <label for="DueWeek">Due Week</label>
                    <input type="text" class="form-control dialoginput" id="DueWeek" name="DueWeek"
                           placeholder="Input Week Number" <?php if (isset($_GET['week'])) {
                        $w = $_GET['week'];
                        echo "value='" . $w . "'";
                    } ?> required>
                    <br>
                    <label for='Title'>Title</label>
                    <input type="text" class="form-control" id="Title" name="Title"
                           placeholder="Input Title" value="" required>
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
        //if edit, disable quiz type
        dialogInputArr.eq(quizTypeIndex).attr('disabled', 'disabled');
    });
    $('.glyphicon-plus').on('click', function () {
        $("label").remove(".error");
        $('#dialogTitle').text("Add <?php echo $pageNameForView ?>");
        $('#update').val(1);
        //enable all the buttons
        for (i = 0; i < dialogInputArr.length; i++) {
            dialogInputArr.eq(i).prop('disabled', false);
            if (i != 1) {
                dialogInputArr.eq(i).val('');
            } else {
                <?php if(!isset($_GET['week'])){?>
                dialogInputArr.eq(i).val('');
                <?php } ?>
            }
        }
    });
    $('.glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this Competition?')) {
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
                DueWeek: {
                    required: true,
                    digits: true
                },
                Title: {
                    required: true
                }
            }
        });
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
            } else if ($(this).val().trim()=="MCQ"){
                dialogInputArr.eq(pointsIndex).attr('disabled', 'disabled');
            } else{
                dialogInputArr.eq(pointsIndex).prop('disabled', false);
            }
        });
    });
</script>
</body>

</html>
