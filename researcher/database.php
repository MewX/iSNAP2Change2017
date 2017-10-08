<?php
session_start();
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
require_once('researcher-validation.php');


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
                header("Location: account.php"); // ==> ../index.php
            }
            else if ($update == 0) {
                // update
                $userName = $_POST['Username'];
                $password = $_POST['Password'];
                $researcherID = $_POST['ResearcherID'];
                updateResearcher($conn, $userName, $password, $researcherID);
                $currentUserId = $_SESSION["researcherID"];
                if($currentUserId == 1){
                    header("Location: account.php"); // ==> ../index.php
                }

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
                    header("Location: account.php"); // ==> ../index.php
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
                <h1 class="page-header">Database Administration</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Database Backup and Restore
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- The data encoding type, enctype, MUST be specified as below -->
                        <div>
                            <h4>Database restore</h4>
                            <div class="alert alert-info">
                                <p>You can restore your database by choosing a file and then click the restore button.</p>
                            </div>
                            <form enctype="multipart/form-data" action="../backup_restore_db/myphp-restore.php" method="POST">
                                <!-- MAX_FILE_SIZE must precede the file input field -->
                                <input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
                                <!-- Name of input element determines name in $_FILES array -->
                                <input name="userfile" type="file" id="upload"/>
                                <br>
                                <input type="submit" value="Restore" class="btn btn-default"/>
                            </form>
                        </div>
                        <hr noshade>
                        <div>
                            <h4>Database Backup</h4>
                            <div class="alert alert-info">
                                <p>
                                    You can download a backup for database by clicking the <b>backup</b> link below.
                                    You can restore your database by uploading the backup files
                                </p>
                                <br>
                                <a href="../backup_restore_db/myphp-backup.php">backup</a>
                            </div>
                        </div>
                        <div>
                            <h4>Get CSV File</h4>
                            <div class="alert alert-info">
                                <p>
                                    You can download a .csv file for database by clicking the <b>Generate</b> link below.
                                </p>
                                <br>
                                <a href="../backup_restore_db/generateCSV.php">Generate</a>
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

<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>

<!-- Page-Level Scripts -->
<script>

</script>
</body>

</html>
