<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 10/17/2017
 * Time: 11:09 PM
 */
// check login status
require_once('./student-validation.php');

require_once("../mysql-lib.php");

// TODO: get achievement unlocking progress

// assign variables to corresponding variables
$aQuizMaster = false; // get all other achievements on weekly quiz

$aAllSnapFacts = false; // visit every snap fact category
$aResourcePage = false; // visit the resources page
$aQuizLeaderBoardTopTenOnce = false; // be in the top ten on the leader board once
$aLearningFromMistakes = false; // check teacher's feedback once
$aHeadOfClass = false; // get full marks on everything
$aWeeklyGenius = false; // get full marks on every task for any week
$aGotItRight = false; // get full marks for every multiple choice task
$aAced = false; // get full marks for any task
$aHatTrick = false; // get full marks on 'one' task for three weeks in a row
$aMasterExtraContent = false; // play every after school quiz


$aLoginMaster = false; // unlock every log in achievement

$aLoginWeek1 = false;
$aLoginWeek2 = false;
$aLoginWeek3 = false;
$aLoginWeek4 = false;
$aLoginWeek5 = false;
$aLoginWeek6 = false;
$aLoginWeek7 = false;
$aLoginWeek8 = false;
$aLoginWeek9 = false;
$aLoginWeek10 = false;


$aMasterGaming = false; // unlock every gaming achievement

$aLaunchSportsNinja = false; // launch sports ninja once
$aPlayEveryGameModeSn = false;
$aBeatScoreSnA = false; // beat xxx score
$aBeatScoreSnB = false; // beat xxxx score
$aBeatScoreSnC = false; // beat xxxxx score

$aLaunchMealCrusher = false; // launch meal crusher once
$aPlayEveryGameModeMc = false;
$aBeatScoreMcA = false; // beat xxx score
$aBeatScoreMcB = false; // beat xxxx score
$aBeatScoreMcC = false; // beat xxxxx score


// TODO: do we still need smoking specific achievements?
// TODO: because the theme is smoking already.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Achievements | SNAP²</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/snap.ico" />
    <link rel="stylesheet" href="./css/common.css">
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="./js/snap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <style>
        .reading-detail {
            padding-top: 20px;
        }
        .reading-header {
            text-align: center;
        }
        .achievement-logo {
            width: 128px;
            height: 128px;
            margin: 0 auto;
            background-size: 100% 100%;
            background-image: url("./img/achievement_logo.png");
        }
        .achievement-logo-locked {
            width: 128px;
            height: 128px;
            margin: 0 auto;
            background-size: 100% 100%;
            background-image: url("./img/locked_icon.png");
        }
        .reading-title {
            font-size: 28px;
        }
        .reading-intro {
            width: 300px;
            font-family: "Maitree", serif;
            font-size: 18px;
            margin: 0 auto;
        }
        .material-content p {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .achievement-name {
            font-family: "Maitree", serif;
            margin-top: 12px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="page-wrapper" style="color: white">
    <? require("./top-nav-bar.php") ?>

    <div class="content-wrapper">
        <div class="reading-detail">
            <div class="reading-header">
                <div class="achievement-logo"></div>
                <div class="reading-title">Achievements</div>
                <div class="reading-intro">Unlock achievements by completing the requirements while you're playing SNAP².</div>
                <div class="reading-intro"><i>(Hint: Move your mouse upon the achievement icons to view how to achieve them!)</i></div>
            </div>
        </div>

        <div class="col-4 col-xs-offset-4" style="margin-top: 60px; padding: 40px; border-radius: 30px; background-color: black">
            <div class="col-4" style="text-align: center">
                <div class="achievement-logo<? echo $aQuizMaster ? "" : "-locked" ?>"
                     title="Unlock this achievement by unlocking all other quiz achievements."></div>
                <div class="achievement-name">Quiz Master</div>
            </div>
            <div class="col-4" style="text-align: center">
                <div class="achievement-logo<? echo $aLoginMaster ? "" : "-locked" ?>"
                     title="Unlock this achievement by unlocking all other log-in achievements."></div>
                <div class="achievement-name">Log-in Master</div>
            </div>
            <div class="col-4" style="text-align: center">
                <div class="achievement-logo<? echo $aMasterGaming ? "" : "-locked" ?>"
                     title="Unlock this achievement by unlocking all other game achievements."></div>
                <div class="achievement-name">Game Master</div>
            </div>
        </div>

        <div class="col-8 col-xs-offset-2" style="margin-top: 120px">
            <div class="col-2 col-xs-offset-1">1</div>
            <div class="col-2">1</div>
            <div class="col-2">1</div>
            <div class="col-2">1</div>
            <div class="col-2">1</div>
        </div>

    </div>
    <? require("./left-nav-bar.php") ?>
    <? require("./footer-bar.php") ?>
</div>
</body>
</html>
