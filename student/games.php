<?php
    //check login status
    require_once('./student-validation.php');
    require_once("../mysql-lib.php");
    require_once("../debug.php");

    $pageName = "games";
    $conn = null;

    try {
        $conn = db_connect();

        //get quiz viewed attribute
        $quizViewedAttrs = getQuizViewdAttr($conn, $studentID);

        //get student question viewed attribute
        $studentQuesViewedAttrs = getStudentQuesViewedAttr($conn, $studentID);

        //get student week
        $studentWeek = getStudentWeek($conn, $studentID);

    } catch(Exception $e) {
        if($conn != null) {
            db_close($conn);
        }

        debug_err($e);
    }

    db_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Games | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link rel="stylesheet" href="./css/common.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="./js/snap.js"></script>
    <style>

        .extra-activities-detail {
            padding-top: 20px;
        }
        .extra-activities-header {
            text-align: center;
        }
        .extra-activities-logo {
            width: 128px;
            height: 128px;
            margin: 0 auto;
            background-size: 100% 100%;
            background-image: url("./img/start_flag_icon.png");
        }
        .extra-activities-title {
            font-size: 28px;
        }
        .extra-activities-intro {
            width: 300px;
            font-family: "Maitree", serif;
            font-size: 18px;
            margin: 0 auto;
        }

        @keyframes fadein {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        .post .content
        {
            padding: 15px;
        }
        .post .author
        {
            font-size: 11px;
            color: #737373;
            padding: 25px 30px 20px;
        }
        .post .post-img-content
        {
            height: 260px;
            position: relative;
        }
        .post .post-img-content img
        {
            position: absolute;
        }
        .post .post-title
        {
            display: table-cell;
            vertical-align: bottom;
            z-index: 2;
            position: relative;
        }
        .post .post-title b
        {
            background-color: rgba(51, 51, 51, 0.58);
            display: inline-block;
            margin-bottom: 5px;
            color: #FFF;
            padding: 10px 15px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="header-wrapper">
        <div class="header">
            <a class="home-link" href="welcome.php">SNAP²</a>
            <ul class="nav-list">
                <li class="nav-item"><a  class="nav-link" href="game-home.php">Dashboard</a></li>
                <li class="nav-item"><a  class="nav-link" href="snap-facts.php">SNAP² Facts</a></li>
                <li class="nav-item"><a  class="nav-link" href="resources.php">Resources</a></li>
            </ul>
            <div class="settings">
                <div class="info-item info-notification">
                    <a class="info-icon" href="javascript:;"></a>
                    <?php           if (count($quizViewedAttrs) != 0) { ?>
                        <span class="info-number"><?php echo count($quizViewedAttrs) ?></span>
                    <?php           } ?>
                    <ul class="info-message-list">
                        <?php           for ($i = 0; $i < count($quizViewedAttrs); $i++) {
                            if ($quizViewedAttrs[$i]["extraQuiz"] == 0) {
                                $url = "weekly-task.php?week=".$quizViewedAttrs[$i]["week"];
                            } else {
                                $url = "extra-activities.php?week=".$quizViewedAttrs[$i]["week"];
                            }?>
                            <li class="info-message-item">
                                <a href="<?php echo $url ?>">
                                    <?php
                                    $message = "A ";

                                    switch($quizViewedAttrs[$i]["quizType"]) {
                                        case "Video":
                                            $message = $message."Video task";
                                            break;
                                        case "Image":
                                            $message = $message."Image task";
                                            break;
                                        case "SAQ":
                                            $message = $message."Short Answer Question task";
                                            break;
                                        case "Poster":
                                            $message = $message."Poster task";
                                            break;
                                    }

                                    $message = $message." in Week ".$quizViewedAttrs[$i]["week"]." has feedback for you.";
                                    echo $message;
                                    ?>
                                </a>
                            </li>
                        <?php           } ?>
                    </ul>
                </div>

                <div class="info-item info-message">
                    <a class="info-icon" href="javascript:;"></a>
                    <?php           if (count($studentQuesViewedAttrs) != 0) { ?>
                        <span class="info-number"><?php echo count($studentQuesViewedAttrs) ?></span>
                    <?php           } ?>
                    <ul class="info-message-list">
                        <li class="info-message-item">
                            <?php
                            for ($i = 0; $i < count($studentQuesViewedAttrs); $i++) { ?>
                                <a href="messages.php">
                                    You message about <?php echo $studentQuesViewedAttrs[$i]->Subject ?> has been replied.
                                </a>
                            <?php               } ?>
                        </li>
                    </ul>
                </div>

                <div class="setting-icon dropdown">
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="settings.php">Settings</a></li>
                        <li class="dropdown-item"><a href="logout.php">Log out</a></li>
                    </ul>
                </div>
                <a class="setting-text"><?php echo $_SESSION["studentUsername"]?></a>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="row" style="color: white; font-size: 16pt;">
            <div class="col-6  col-md-offset-3">
                <div class="extra-activities-detail">
                    <div class="extra-activities-header">
                        <div class="extra-activities-logo"></div>
                        <div class="extra-activities-title" style="padding: 20px;">Game Downloads</div>
                        <div class="extra-activities-intro">Download games and compete with each other!</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two games -->
        <div class="row" style="color: white; font-size: 16pt; padding-top: 24px">
            <div class="col-6  col-xs-offset-3">
                <div class="col-sm-6">
                    <div class="post">
                        <div class="post-img-content">
                            <img src="img/Candy.jpg" class="img-responsive" />
                            <span class="post-title"><b>Candy Crush</b><br /></span>
                        </div>
                        <div class="content">
                            <div>
                                Control and eliminate candies to win.
                            </div>
                            <div>
                                <a href="#" class="btn btn-warning btn-sm">Download</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="post">
                        <div class="post-img-content">
                            <img src="img/Fruit.jpg" class="img-responsive" />
                            <span class="post-title"><b>Fruit Ninja</b><br /></span>
                        </div>
                        <div class="content">
                            <div>
                                Eat fruits and refuse smoking.
                            </div>
                            <div>
                                <a href="#" class="btn btn-warning btn-sm">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <ul class="sitenav">
        <li class="sitenav-item sitenav-game-home"><a href="games.php" data-toggle="tooltip" title="Game Home"></a></li>
        <li class="sitenav-item sitenav-extra-activities"><a href="extra-activities.php" data-toggle="tooltip" title="Extra Activities"></a></li>
        <li class="sitenav-item sitenav-progress"><a href="progress.php" data-toggle="tooltip" title="Progress"></a></li>
        <li class="sitenav-item sitenav-reading-material"><a href="reading-material.php" data-toggle="tooltip" title="Reading Materials"></a></li>
    </ul>
    <div class="footer-wrapper">
        <div class="footer">
            <div class="footer-content">
                <a href="#" class="footer-logo"></a>
                <ul class="footer-nav">
                    <li class="footer-nav-item"><a href="#">Any Legal Stuff</a></li>
                    <li class="footer-nav-item"><a href="#">Acknowledgements</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
