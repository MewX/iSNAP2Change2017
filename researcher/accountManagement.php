<?php
session_start();
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");

//if insert/update/remove researcher
try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $update = $_POST['update'];
            if ($update == 1) {
                // insert
                $userName = $_POST['Username'];
                $passWord = $_POST['Password'];
                createResearcher($conn, $userName, $passWord);
                header("Location: accountManagement.php"); // ==> ../index.php
            }
            else if ($update == 0) {
                // update
                $userName = $_POST['Username'];
                $researcherID = $_POST['ResearcherID'];
                updateResearcher($conn, $userName, $researcherID);
                header("Location: accountManagement.php"); // ==> ../index.php
            }
            else if ($update == -1) {
                // remove school (with help of DELETE CASCADE)
                $researcherID = $_POST['ResearcherID'];
                //super account (id=1) cannot be deleted
                if($researcherID==1){
                    echo '<script language="javascript">';
                    echo 'alert("This is a super account which cannot be deleted")';
                    echo '</script>';
                }else{
                    deleteResearcher($conn, $researcherID);
                    header("Location: accountManagement.php"); // ==> ../index.php
                }
            }

        }
    }


} catch (Exception $e) {
    debug_err($e);
}

try {
    $researcherResult = getResearchers($conn);
    $classNumResult = getClassNum($conn);
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
                <h1 class="page-header">Account Administration</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Account Table <span class="glyphicon glyphicon-plus pull-right" data-toggle="modal"
                                                       data-target="#dialog"></span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th >ResearcherID</th>
                                    <th>Username</th>
                                    <th style="display:none">Password</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php for ($i = 0; $i < count($researcherResult); $i++) { ?>
                                    <tr class="<?php if ($i % 2 == 0) {
                                        echo "odd";
                                    } else {
                                        echo "even";
                                    } ?>">
                                        <td ><?php echo $researcherResult[$i]->ResearcherID ?></td>
                                        <td>
                                            <a href="class.php?ResearcherID=<?php echo $researcherResult[$i]->ResearcherID ?>">
                                                <?php echo $researcherResult[$i]->Username ?>
                                            </a>
                                            <span class="glyphicon glyphicon-remove pull-right"
                                                  aria-hidden="true"></span><span class="pull-right" aria-hidden="true">&nbsp;
                                            </span>
                                            <span
                                                    class="glyphicon glyphicon-edit pull-right" data-toggle="modal"
                                                    data-target="#dialog" aria-hidden="true">
                                            </span>
                                        </td>
                                        <td style="display:none">Password</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <div class="well row">
                            <h4>Researcher Overview Notification</h4>
                            <div class="alert alert-info">
                                <p>View researcher by filtering or searching. You can create/update/delete any researcher.</p>
                            </div>
                            <div class="alert alert-danger">
                                <p><strong>Reminder</strong> : If there is any
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
                <h4 class="modal-title" id="dialogTitle">Edit School</h4>
            </div>
            <div class="modal-body">
                <form id="submission" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!--if 1, insert; else if 0 update; else if -1 delete;-->
                    <input type=hidden name="update" id="update" value="1">
                    <label for="ResearcherID" style="display:none">ResearcherID</label>
                    <input type="text" class="form-control dialoginput" id="ResearcherID" name="ResearcherID"
                           style="display:none">
                    <label for="Username">Username</label>
                    <input type="text" class="form-control dialoginput" id="Username" name="Username">
                    <br>
                    <label for="Password">Password</label>
                    <input type="password" class="form-control dialoginput" id="Password" name="Password">
                    <br>
                    <label for="cPassword">Confirmed Password</label>
                    <br>
                    <span id='message'></span>
                    <input type="password" class="form-control dialoginput" id="cPassword" name="cPassword">
                    <br>
                    <div class="alert alert-danger">
                        <p><strong>Reminder</strong> : Username of researcher should be unique and no duplicate names are allowed.
                        </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" class="btn btn-default" name="save">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [0]}
            ]
        });
    });
    //DO NOT put them in $(document).ready() since the table has multi pages
    var dialogInputArr = $('.dialoginput');
    $('.glyphicon-edit').on('click', function () {
		$("label").remove(".error");
        $('#dialogTitle').text("Edit <?php echo $pageNameForView ?>");
        $('#update').val(0);
        for (i = 0; i < dialogInputArr.length; i++) {
            dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
        }

        //disable SchoolID and Classes
//        dialogInputArr.eq(0).attr('disabled', 'disabled');
//        dialogInputArr.eq(2).attr('disabled', 'disabled');
    });
    $('.glyphicon-plus').on('click', function () {
		$("label").remove(".error");
        $('#dialogTitle').text("Add <?php echo $pageNameForView ?>");
        $('#update').val(1);
        for (i = 0; i < dialogInputArr.length; i++) {
            dialogInputArr.eq(i).val('');
        }
        //disable SchoolID and Classes
//        dialogInputArr.eq(0).attr('disabled', 'disabled');
//        dialogInputArr.eq(2).attr('disabled', 'disabled');
    });
    $('.glyphicon-remove').on('click', function () {
        if (confirm('[WARNING] Are you sure to remove this researcher? All the researcher data will also get deleted (not recoverable).')) {
            $('#update').val(-1);
            //fill required input
            dialogInputArr.eq(0).prop('disabled', false);
            for (i = 0; i < dialogInputArr.length; i++) {
                dialogInputArr.eq(i).val($(this).parent().parent().children('td').eq(i).text().trim());
            }
            $('#submission').submit();
        }
    });
    $('#btnSave').on('click', function () {
        $('#submission').validate();
        //enable SchoolID
        dialogInputArr.eq(0).prop('disabled', false);
        $('#submission').submit();
    });

    $('#Username').on('keyup', function () {
        console.log("pressed");
        <?php
        $conn = db_connect();
        echo $_POST['Username'];
        if(checkResearcherUsernameExisting($conn,$_POST['Username'])){
            echo '$(\'#message\').html(\'existing\').css(\'color\', \'red\')';
        }else{
            echo '$(\'#message\').html(\'valid unsername\').css(\'color\', \'green\')';
        };
        ?>

    });


    $('#Password, #cPassword').on('keyup', function () {
        if (($('#Password').val() == $('#cPassword').val()) && $('#Password').val()!="") {
            $('#message').html('Matching').css('color', 'green');
        } else
            $('#message').html('Not Matching').css('color', 'red');
    });
</script>
</body>

</html>
