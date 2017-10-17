<?php
//check login status
require_once('student-validation.php');

require_once("../mysql-lib.php");
require_once("../debug.php");
$pageName = "competition";

$conn = null;

try {
    $conn = db_connect();
    $competitionResults = getCompetitions($conn);
} catch(Exception $e) {
    if($conn != null) {
        db_close($conn);
    }

    debug_err($e);
    //to do: handle sql error
    //...
    exit;
}

db_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Pre Task Material | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link rel="stylesheet" href="./css/common.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./js/snap.js"></script>
    <style>
        .material {
            max-width: 1000px;
            margin: 0 auto;
        }
        .material-title {
            text-align: center;
            font-size: 24px;
            max-width: 700px;
            margin: 20px auto;
        }
        .material-content-included {
            padding: 14px 120px;
            background-color: #dedfdf;
            border-radius: 10px;
            color: #000;
            min-height: 350px;
            margin-bottom: 50px;
        }
        .material-content-included p {
            margin: 0 0 30px 0;
        }

    </style>
</head>
<body>

<div class="page-wrapper">
    <?php
    require("./top-nav-bar.php");
    ?>

    <div class="content-wrapper">
        <div class="material">
            <?php for($i=0; $i<count($competitionResults); $i++){?>
                <h2 class="material-title"> <?php echo $competitionResults[$i]->Title ?> | Due at Week <?php echo $competitionResults[$i]->DueWeek ?></h2>
                <div class="material-content-included p1">
                    <?php echo $competitionResults[$i]->Content; ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <? require("./footer-bar.php") ?>
</div>
<script>
    snap.enableBackTop()
</script>
</body>
</html>

