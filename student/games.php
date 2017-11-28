<?php
    //check login status
    require_once('./student-validation.php');
    require_once("../mysql-lib.php");
    require_once("../debug.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Games | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="./js/snap.js"></script>
    <link rel="stylesheet" href="./css/common.css">
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

        .post .post-img-content
        {
            position: relative;
        }
        .post .post-title
        {
            display: table-cell;
            vertical-align: bottom;
            z-index: 2;
            position: absolute;
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
    <? require('./top-nav-bar.php') ?>

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
                            <span class="post-title"><b>Candy Crush</b><br /></span>
                            <img src="img/foodCrush.jpg" class="img-responsive"/>
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
                            <span class="post-title"><b>Fruit Ninja</b><br /></span>
                            <img src="img/sportNinja.jpg" class="img-responsive"/>
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

    <? require("./left-nav-bar.php") ?>
    <? require("./footer-bar.php") ?>
</div>
</body>
</html>
