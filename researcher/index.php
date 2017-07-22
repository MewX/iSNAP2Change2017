<?php
session_start();
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
$conn = db_connect();
$connLog = db_connect('log');

try {
    $bugNum = getUnsolvedLogNum($connLog);
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
    <!-- Navigation Layout-->
    <?php require_once('navigation.php');
    if (isset($_SESSION['researcherID']) && isset($_SESSION['researcherUsername'])):
        require_once ('dashboard.php');
    else: ?>
        <div class="jumbotron">
            <h1 align="center">Welcome to SNAP for Researcher</h1>

            <h2 align="center">
                Please click the button to log in.
            </h2>
            <p class="logInBtn"><a class="btn btn-primary btn-lg" data-toggle="modal" href="#myModal"
                  role="button">Log in</a></p>

        </div>
    <? endif; ?>
</div>

    <style>
        .logInBtn {
            text-align: center;
        }
    </style>

<!-- SB Admin Library -->
<?php require_once('sb-admin-lib.php'); ?>
<!-- Page-Level Scripts -->
<script>
</script>
</body>

</html>
