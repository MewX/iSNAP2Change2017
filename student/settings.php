<?php

    //check login status
    require_once('./student-validation.php');

    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "settings";

    $conn = null;

    try{
        $conn = db_connect();

        //get student account information
        $studentInfo = getStudent($conn, $studentID);

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
    <title>Setting | SNAP</title>
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" type="text/css" href="./css/vendor/animate.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <script src="./js/vendor/wow.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <style>
        .setting-content {
            max-width: 1000px;
            margin: 30px auto;
            text-align: center;
        }
        .setting-logo {
            width: 128px;
            height: 128px;
            margin: 0 auto 20px;
            background-size: 100% 100%;
            background-image: url("./img/settings_icon.png");
        }
        .setting-label {
            font-size: 28px;
        }
        .setting-prompt {
            font-size: 18px;
            font-family: Maitree, serif;
        }

        .account-info {
            max-width: 700px;
            margin: 0 auto;
        }
        .account-title {
            margin: 30px 0;
            font-size: 20px;

        }
        .addition-info {
            max-width: 600px;
            margin: 40px auto;
        }
        .addition-title {
            text-align: center;
            margin: 0 auto 20px;
            font-size: 18px;
        }
        .addition-field {
            display: block;
            width: 400px;
            margin: 0 auto;
            height: 350px;
            font-size: 18px;
        }
        .addition-footer {
            padding: 20px;
        }
        .addition-submit {
            width: 100px;
            height: 40px;
            margin: 0 auto;
            cursor: pointer;
            background-size: 100% 100%;
            background-color: #000;
            border: 0;
            background-image: url("./img/send_icon.png");
        }
        .addition-submit:focus {
            outline: 0;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="header-wrapper">
        <div class="header">
            <a class="home-link" href="welcome.php">SNAP</a>
            <ul class="nav-list">
                <li class="nav-item"><a  class="nav-link" href="game-home.php">Snap Change</a></li>
                <li class="nav-item"><a  class="nav-link" href="snap-facts.php">Snap Facts</a></li>
                <li class="nav-item"><a  class="nav-link" href="#">Resources</a></li>
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
                        <li class="dropdown-item"><a href="logout.php">Log out</a></li>
                    </ul>
                </div>
                <a class="setting-text"><?php echo $_SESSION["studentUsername"]?></a>
            </div>
        </div>
    </div>


    <div class="content-wrapper">
        <div class="setting-content">
            <div class="setting-header">
                <div class="setting-logo"></div>
                <div class="setting-label p1" style="color: white">Settings</div>
                <div class="setting-prompt p1" style="color: white">Change your account settings</div>
            </div>
            <div class="account-info">
                <h2 class="account-title" style="color: white">Account Information</h2>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="username" style="color: #FCEE2D">Username:</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="username" placeholder="Enter username" value="<?php echo $studentInfo->Username?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email" style="color: #FCEE2D">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo $studentInfo->Email?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="oldpass" style="color: #FCEE2D">Old password for verification:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="oldpass" placeholder="Enter old password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="newpass" style="color: #FCEE2D">New password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="newpass" placeholder="Enter new password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="newpass2" style="color: #FCEE2D">New password again:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="newpass2" placeholder="Enter new password again">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-default" onclick="submitChanges()">Update</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="addition-info">
<!--                TODO: Add a link to notification centre-->
                <div class="addition-title p1" style="color: white">Any issues of questions?<br/>Please contact the researcher in your notification centre.</div>
            </div>
        </div>

    </div>

    <ul class="sitenav">
        <li class="sitenav-item sitenav-healthy-recipes"><a href="#" data-toggle="tooltip" title="Healthy Recipes"></a></li>
        <li class="sitenav-item sitenav-game-home"><a href="#" data-toggle="tooltip" title="Game Home"></a></li>
        <li class="sitenav-item sitenav-extra-activities"><a href="extra-activities.php" data-toggle="tooltip" title="Extra Activities"></a></li>
        <li class="sitenav-item sitenav-progress"><a href="progress.php" data-toggle="tooltip" title="Progress"></a>
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


<script>
    function submitChanges() {
        // todo
    }
</script>
</body>
</html>



