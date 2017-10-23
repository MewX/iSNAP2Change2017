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
                    $competitionID = $_POST['CompetitionID'];
                    $dueWeek = $_POST['DueWeek'];
                    $title = $_POST['Title'];
                    updateCompetition($conn, $competitionID, $dueWeek, $title);
                } catch (Exception $e) {
                    debug_err($e);
                    $conn->rollBack();
                }
            }
        }
    }
} catch (Exception $e) {
    debug_err($e);
}

try {
    if (isset($_GET['competitionID'])) {
        $competitionID = $_GET['competitionID'];
        $competitionResult = getCompetition($conn, $competitionID);
        $phpSelf = $pageName . '.php?competitionID=' . $competitionID;
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
                <h1 class="page-header">Competition Editor
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
                        Competition
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form id="metadata-submission" method="post" action="<?php echo $phpSelf; ?>">
                            <!--if 0 update; else if -1 delete;-->
                            <input type=hidden name="metadataUpdate" id="metadataUpdate" value="1" required>
                            <label for="CompetitionID" style="display:none">CompetitionID</label>
                            <input type="text" class="form-control" id="CompetitionID" name="CompetitionID" style="display:none"
                                   value="<?php echo $competitionResult->CompetitionID; ?>">
                            <br>
                            <label for="DueWeek">Due Week</label>
                            <input type="text" class="form-control" id="DueWeek" name="DueWeek"
                                   placeholder="Input Week Number" value="<?php echo $competitionResult->DueWeek; ?>">
                            <br>
                            <label for='Title'>Title</label>
                            <input type="text" class="form-control" id="Title" name="Title"
                                   placeholder="Input Title" value="<?php echo $competitionResult->Title; ?>" required>
                        </form>
                        <!--edit metadata-->
                        <button type="button" class="btn btn-default btn-lg text-center pull-right" id="metadata-save">Save Changes</button>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Learning Material Editor
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" style="height: 700px;">
                        <div class="heading" style="color: black; max-height:10vh; text-align:center; border-bottom: 1px solid #eee;">
                        </div>
                        <iframe id="learning-material-editor" src="competition-material-editor.php?competitionID=<?php echo $competitionID; ?>"
                                scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true"
                                name="Learning Material Editor" title="Learning Material Editor"
                                style="width: 100%; height:100%;"></iframe>
                    </div>
                    <!-- /.panel-body -->
                    <div class="panel-footer">
                        <h4><?php echo $pageNameForView; ?> Notification</h4>
                        <div class="alert alert-info">
                            <p>You need to click the save button to save your changes in the editor</p>
                        </div>
                        <div class="alert alert-info">
                            <p>If you want to upload a picture on your computer to this editor, please:<br>
                                1. Upload your picture to https://imgur.com/upload<br>
                                2. Click get share link, copy the BBCode (Forums)<br>
                                3. In our editor, click the image icon, paste this link in to Source text box.<br>
                                4. Remove[img] and [/img/ before/after this link<br>
                                5. click ok<br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>

<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>
<!-- Page-Level Scripts -->
<script>

    $(document).ready(function () {
        $('#metadata-save').on('click', function () {
            $('#metadataUpdate').val(0);
            $('#metadata-submission').validate({
                rules: {
                    DueWeek: {
                        required: true,
                        digits: true
                    },
                    Title: {
                        required: true,
                    }
                }
            });
            $('#metadata-submission').submit();
        });
    });

    function goBack() {
        var week = document.getElementById("DueWeek");
        var title = document.getElementById("Title");
        var weekIsChanged = week.value != week.defaultValue;
        var titleIsChanged = title.value != title.defaultValue;
        if(weekIsChanged||titleIsChanged){
            if(confirm("[Warning] You haven't save your changes, do you want to leave this page?")){
                location.href='<?php echo "competition.php" ?>'            }
        }else{
            location.href='<?php echo "competition.php" ?>'
        }
    }
</script>
<script src="researcher-tts.js"></script>
</body>

</html>
