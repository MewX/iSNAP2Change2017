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
require_once("../achievement-lib.php");

// get achievement unlocking progress
$conn = db_connect();
markUnviewedAchievementsAsViewed($conn, $studentID);
$allAch = achGetAllAchievementsByStudentId($conn, $studentID);

// assign variables to corresponding variables
$aQuizMaster = $allAch->QuizMaster; // get all other achievements on weekly quiz

$aAllSnapFacts = $allAch->AllSnapFacts; // visit every snap fact category
$aResourcePage = $allAch->ResourcePage; // visit the resources page
$aQuizLeaderBoardTopTenOnce = $allAch->QuizLeaderBoardTopTenOnce; // be in the top ten on the leader board once
$aLearningFromMistakes = $allAch->LearningFromMistakes; // check teacher's feedback once
$aHeadOfClass = $allAch->HeadOfClass; // get full marks on everything
$aWeeklyGenius = $allAch->WeeklyGenius; // get full marks on every task for any week
$aGotItRight = $allAch->GotItRight; // get full marks for every multiple choice task
$aAced = $allAch->Aced; // get full marks for any task
$aHatTrick = $allAch->HatTrick; // get full marks on 'one' task for three weeks in a row
$aMasterExtraContent = $allAch->MasterExtraContent; // play every after school quiz

$aLoginMaster = $allAch->LoginMaster; // unlock every log in achievement

$aLoginWeek1 = $allAch->LoginWeek1;
$aLoginWeek2 = $allAch->LoginWeek2;
$aLoginWeek3 = $allAch->LoginWeek3;
$aLoginWeek4 = $allAch->LoginWeek4;
$aLoginWeek5 = $allAch->LoginWeek5;
$aLoginWeek6 = $allAch->LoginWeek6;
$aLoginWeek7 = $allAch->LoginWeek7;
$aLoginWeek8 = $allAch->LoginWeek8;
$aLoginWeek9 = $allAch->LoginWeek9;
$aLoginWeek10 = $allAch->LoginWeek10;

$aMasterGaming = $allAch->MasterGaming; // unlock every gaming achievement

$aLaunchSportsNinja = $allAch->LaunchSportsNinja; // launch sports ninja once
$aPlayEveryGameModeSn = $allAch->PlayEveryGameModeSn;
$aBeatScoreSnA = $allAch->BeatScoreSnA; // beat xxx score
$aBeatScoreSnB = $allAch->BeatScoreSnB; // beat xxxx score
$aBeatScoreSnC = $allAch->BeatScoreSnC; // beat xxxxx score

$aLaunchMealCrusher = $allAch->LaunchMealCrusher; // launch meal crusher once
$aPlayEveryGameModeMc = $allAch->PlayEveryGameModeMc;
$aBeatScoreMcA = $allAch->BeatScoreMcA; // beat xxx score
$aBeatScoreMcB = $allAch->BeatScoreMcB; // beat xxxx score
$aBeatScoreMcC = $allAch->BeatScoreMcC; // beat xxxxx score

// TODO: do we still need smoking specific achievements?
// TODO: because the theme is smoking already.

db_close($conn);
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
            width: 100%;
            height: auto;
            max-width: 128px;
            max-height: 128px;
        <?
            define("IMG_ACHIEVED", "img/achievement_logo.png");
            define("IMG_LOCKED", "img/locked_icon.png");
        ?>
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
        .myrow {
            margin-top: 48px;
        }
        .mybox {
            text-align: center;
        }

    </style>
</head>
<body>

<div class="page-wrapper" style="color: white">
    <? require("./top-nav-bar.php") ?>

    <div class="content-wrapper">
        <div class="reading-detail">
            <div class="reading-header">
                <img class="achievement-logo" src="<? echo IMG_ACHIEVED ?>"
                     title="Unlock this achievement by unlocking all other quiz achievements."/>
                <div class="reading-title">Achievements</div>
                <div class="reading-intro">Unlock achievements by completing the requirements while you're playing SNAP².</div>
                <div class="reading-intro"><i>(Hint: Move your mouse upon the achievement icons to view how to achieve them!)</i></div>
            </div>
        </div>

        <div class="row" style="margin-top: 60px; margin-bottom: 60px">
            <!-- Master achievements -->
            <div class="col-4 col-xs-offset-4" style="padding: 24px; border-radius: 30px; background-color: black">
                <div class="col-4 mybox">
                    <img class="achievement-logo" src="<? echo $aQuizMaster ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by unlocking all other quiz achievements."/>
                    <div class="achievement-name">Quiz Master</div>
                </div>
                <div class="col-4 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginMaster ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by unlocking all other log-in achievements."/>
                    <div class="achievement-name">Log-in Master</div>
                </div>
                <div class="col-4 mybox">
                    <img class="achievement-logo" src="<? echo $aMasterGaming ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by unlocking all other game achievements."/>
                    <div class="achievement-name">Game Master</div>
                </div>
            </div>

            <!-- Login related achievements -->
            <div class="col-8 col-xs-offset-2 myrow">
                <div class="col-2 col-xs-offset-1 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek1 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 1."/>
                    <div class="achievement-name">Week 1 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek2 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 2."/>
                    <div class="achievement-name">Week 2 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek3 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 3."/>
                    <div class="achievement-name">Week 3 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek4 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 4."/>
                    <div class="achievement-name">Week 4 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek5 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 5."/>
                    <div class="achievement-name">Week 5 Logged in</div>
                </div>
            </div>
            <div class="col-8 col-xs-offset-2 myrow">
                <div class="col-2 col-xs-offset-1 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek6 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 6."/>
                    <div class="achievement-name">Week 6 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek7 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 7."/>
                    <div class="achievement-name">Week 7 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek8 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 8."/>
                    <div class="achievement-name">Week 8 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek9 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 9."/>
                    <div class="achievement-name">Week 9 Logged in</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLoginWeek10 ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by logging in in week 10."/>
                    <div class="achievement-name">Week 10 Logged in</div>
                </div>
            </div>
            <hr class="col-6 col-xs-offset-3 myrow">

            <!-- Quiz related achievements -->
            <div class="col-8 col-xs-offset-2 myrow">
                <div class="col-2 col-xs-offset-1 mybox">
                    <img class="achievement-logo" src="<? echo $aAllSnapFacts ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by visiting every snap fact category."/>
                    <div class="achievement-name">Viewed Snap Facts</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aResourcePage ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by visiting resources page."/>
                    <div class="achievement-name">Viewed Resource</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aQuizLeaderBoardTopTenOnce ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by being in Top 10 on the leader board once."/>
                    <div class="achievement-name">Once in Top 10</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aLearningFromMistakes ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by checking teacher's feedback once."/>
                    <div class="achievement-name">Learned from mistakes</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aHeadOfClass ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by getting full marks on everything."/>
                    <div class="achievement-name">Head of class</div>
                </div>
            </div>
            <div class="col-8 col-xs-offset-2 myrow">
                <div class="col-2 col-xs-offset-1 mybox">
                    <img class="achievement-logo" src="<? echo $aWeeklyGenius ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by getting full marks on every task for any week."/>
                    <div class="achievement-name">Weekly Genius</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aGotItRight ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by getting full marks for every multiple choice task."/>
                    <div class="achievement-name">Got it Right</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aAced ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by getting full marks for any task."/>
                    <div class="achievement-name">Aced</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aHatTrick ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by getting full marks on at least ONE task for three weeks in a row.."/>
                    <div class="achievement-name">Hat Trick</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aMasterExtraContent ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by playing every after school quiz."/>
                    <div class="achievement-name">Master of Extra Content</div>
                </div>
            </div>
            <hr class="col-6 col-xs-offset-3 myrow">

            <!-- Game related achievements -->
            <div class="col-8 col-xs-offset-2 myrow">
                <div class="col-2 col-xs-offset-1 mybox">
                    <img class="achievement-logo" src="<? echo $aLaunchSportsNinja ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by launching Sports Ninja once."/>
                    <div class="achievement-name">Launched Sports Ninja</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aPlayEveryGameModeSn ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by playing every game mode in Sports Ninja."/>
                    <div class="achievement-name">Ninja Clearance</div>
                </div>
                <div class="col-2 mybox">
                    <!-- TODO: update the score here -->
                    <img class="achievement-logo" src="<? echo $aBeatScoreSnA ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by beating xxx score in Sports Ninja."/>
                    <div class="achievement-name">xxx Score Ninja</div>
                </div>
                <div class="col-2 mybox">
                    <!-- TODO: update the score here -->
                    <img class="achievement-logo" src="<? echo $aBeatScoreSnB ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by beating xxx score in Sports Ninja."/>
                    <div class="achievement-name">xxx Score Ninja</div>
                </div>
                <div class="col-2 mybox">
                    <!-- TODO: update the score here -->
                    <img class="achievement-logo" src="<? echo $aBeatScoreSnC ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by beating xxx score in Sports Ninja."/>
                    <div class="achievement-name">xxx Score Ninja</div>
                </div>
            </div>
            <div class="col-8 col-xs-offset-2 myrow">
                <div class="col-2 col-xs-offset-1 mybox">
                    <img class="achievement-logo" src="<? echo $aLaunchMealCrusher ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by launching Meal Crusher once."/>
                    <div class="achievement-name">Launched Meal Crusher</div>
                </div>
                <div class="col-2 mybox">
                    <img class="achievement-logo" src="<? echo $aPlayEveryGameModeMc ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by playing every game mode in Meal Crusher."/>
                    <div class="achievement-name">Crusher Clearance</div>
                </div>
                <div class="col-2 mybox">
                    <!-- TODO: update the score here -->
                    <img class="achievement-logo" src="<? echo $aBeatScoreMcA ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by beating xxx score in Meal Crusher."/>
                    <div class="achievement-name">xxx Score Crusher</div>
                </div>
                <div class="col-2 mybox">
                    <!-- TODO: update the score here -->
                    <img class="achievement-logo" src="<? echo $aBeatScoreMcB ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by beating xxx score in Meal Crusher."/>
                    <div class="achievement-name">xxx Score Crusher</div>
                </div>
                <div class="col-2 mybox">
                    <!-- TODO: update the score here -->
                    <img class="achievement-logo" src="<? echo $aBeatScoreMcC ? IMG_ACHIEVED : IMG_LOCKED ?>"
                         title="Unlock this achievement by beating xxx score in Meal Crusher."/>
                    <div class="achievement-name">xxx Score Crusher</div>
                </div>
        </div>
        </div>
    </div>
    <? require("./left-nav-bar.php") ?>
    <? require("./footer-bar.php") ?>
</div>
</body>
</html>
