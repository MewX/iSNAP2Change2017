<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 10/25/2017
 * Time: 12:05 AM
 *
 * This file store all functions related with achievements.
 * And it should be included in `mysql-lib.php`.
 */


function achCheckRecordExistence(PDO $c, $studentId) {
    $sql = "SELECT * FROM achievements WHERE StudentID = ?";
    $sql = $c->prepare($sql);
    $sql->execute(array($studentId));
    $ret = $sql->fetchAll();
    return count($ret) != 0;
}

function achCreateNewRecord(PDO $c, $studentId) {
    // create a new record in student id
    $sql = "INSERT INTO achievements(StudentID) VALUES (?)";
    $sql = $c->prepare($sql);
    return $sql->execute(array($studentId)); // true on successful
}

function achGetAllAchievements(PDO $c) {
    $sql = "select StudentID,QuizMaster,AllSnapFacts,ResourcePage,QuizLeaderBoardTopTenOnce,LearningFromMistakes,HeadOfClass,WeeklyGenius,GotItRight,Aced,HatTrick,MasterExtraContent,LoginMaster,LoginWeek1,LoginWeek2,LoginWeek3,LoginWeek4,LoginWeek5,LoginWeek6,LoginWeek7,LoginWeek8,LoginWeek9,LoginWeek10,MasterGaming,LaunchSportsNinja,PlayEveryGameModeSn,BeatScoreSnA,BeatScoreSnB,BeatScoreSnC,LaunchMealCrusher,PlayEveryGameModeMc,BeatScoreMcA,BeatScoreMcB,BeatScoreMcC from achievements;";
    $sql = $c->prepare($sql);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_OBJ);
}

function achGetAllAchievementsByStudentId(PDO $c, $studentId) {
    $sql = "select * from achievements where StudentID = ?;";
    $sql = $c->prepare($sql);
    $sql->execute(array($studentId));
    return $sql->fetchAll(PDO::FETCH_OBJ);
}

function markUnviewedAchievementsAsViewed(PDO $c, $studentId) {
    $obj = achGetAllAchievementsByStudentId($c, $studentId)[0];
    $sql = "update achievements set QuizMasterViewed={$obj->QuizMaster},
AllSnapFactsViewed={$obj->AllSnapFacts},
ResourcePageViewed={$obj->ResourcePage},
QuizLeaderBoardTopTenOnceViewed={$obj->QuizLeaderBoardTopTenOnce},
LearningFromMistakesViewed={$obj->LearningFromMistakes},
HeadOfClassViewed={$obj->HeadOfClass},
WeeklyGeniusViewed={$obj->WeeklyGenius},
GotItRightViewed={$obj->GotItRight},
AcedViewed={$obj->Aced},
HatTrickViewed={$obj->HatTrick},
MasterExtraContentViewed={$obj->MasterExtraContent},
LoginMasterViewed={$obj->LoginMaster},
LoginWeek1Viewed={$obj->LoginWeek1},
LoginWeek2Viewed={$obj->LoginWeek2},
LoginWeek3Viewed={$obj->LoginWeek3},
LoginWeek4Viewed={$obj->LoginWeek4},
LoginWeek5Viewed={$obj->LoginWeek5},
LoginWeek6Viewed={$obj->LoginWeek6},
LoginWeek7Viewed={$obj->LoginWeek7},
LoginWeek8Viewed={$obj->LoginWeek8},
LoginWeek9Viewed={$obj->LoginWeek9},
LoginWeek10Viewed={$obj->LoginWeek10},
MasterGamingViewed={$obj->MasterGaming},
LaunchSportsNinjaViewed={$obj->LaunchSportsNinja},
PlayEveryGameModeSnViewed={$obj->PlayEveryGameModeSn},
BeatScoreSnAViewed={$obj->BeatScoreSnA},
BeatScoreSnBViewed={$obj->BeatScoreSnB},
BeatScoreSnCViewed={$obj->BeatScoreSnC},
LaunchMealCrusherViewed={$obj->LaunchMealCrusher},
PlayEveryGameModeMcViewed={$obj->PlayEveryGameModeMc},
BeatScoreMcAViewed={$obj->BeatScoreMcA},
BeatScoreMcBViewed={$obj->BeatScoreMcB},
BeatScoreMcCViewed={$obj->BeatScoreMcC} where StudentID = ?";
    $sql = $c->prepare($sql);
    $sql->execute(array($studentId));
}

// achieve "QuizMaster"
function achCheckAndSetQuizMaster(PDO $c, $studentId) {
    $obj = achGetAllAchievementsByStudentId($c, $studentId)[0];
    if ($obj->QuizMaster == 0 // not achieved
        && $obj->AllSnapFacts && $obj->ResourcePage && $obj->QuizLeaderBoardTopTenOnce && $obj->LearningFromMistakes && $obj->HeadOfClass
        && $obj->WeeklyGenius && $obj->GotItRight && $obj->Aced && $obj->HatTrick && $obj->MasterExtraContent) {
        // set Quiz Master
        $sql = "update achievements set QuizMaster = 1 where StudentID = ?";
        $sql = $c->prepare($sql);
        $sql->execute(array($studentId));
    }
}

// achieve "AllSnapFacts"
function achSetAllSnapFacts(PDO $c, $studentId) {
    $sql = "update achievements set AllSnapFacts = 1 where StudentID = ?";
    $sql = $c->prepare($sql);
    $sql->execute(array($studentId));
}

// achieve "ResourcePage"
function achSetResourcePage(PDO $c, $studentId) {
    $sql = "update achievements set ResourcePage = 1 where StudentID = ?";
    $sql = $c->prepare($sql);
    $sql->execute(array($studentId));
}

// achieve "QuizLeaderBoardTopTenOnce"
// TODO: need to check outside
function achSetQuizLeaderBoardTopTenOnce(PDO $c, $studentId) {
    $sql = "update achievements set QuizLeaderBoardTopTenOnce = 1 where StudentID = ?";
    $sql = $c->prepare($sql);
    $sql->execute(array($studentId));
}

// achieve "LearningFromMistakes"
function achSetLearningFromMistakes(PDO $c, $studentId) {
    $sql = "update achievements set LearningFromMistakes = 1 where StudentID = ?";
    $sql = $c->prepare($sql);
    $sql->execute(array($studentId));
}

// achieve "HeadOfClass"
function achCheckAndSetHeadOfClass(PDO $c, $studentId) {
    // TODO: check
//    $sql = "update achievements set HeadOfClass = 1 where StudentID = ?";
//    $sql = $c->prepare($sql);
//    $sql->execute(array($studentId));
}

// achieve "WeeklyGenius"
function achCheckAndSetWeeklyGenius(PDO $c, $studentId) {
    // TODO: not achieved, and then check weekly marks
//    $sql = "update achievements set HeadOfClass = 1 where StudentID = ?";
//    $sql = $c->prepare($sql);
//    $sql->execute(array($studentId));
}

// achieve "GotItRight"
function achCheckAndSetGotItRight(PDO $c, $studentId) {
    // TODO:
}

// achieve "Aced"
function achCheckAndSetAced(PDO $c, $studentId) {
    // TODO:
}

// achieve "HatTrick"
function achCheckAndSetHatTrick(PDO $c, $studentId) {
    // TODO:
}

// achieve "MasterExtraContent"
function achCheckAndSetMasterExtraContent(PDO $c, $studentId) {
    // TODO:
}


function achLoginAutoChecker(PDO $c, $studentId, $week) {
    $obj = achGetAllAchievementsByStudentId($c, $studentId)[0];
    switch ($week) {
        case 1:
            if ($obj->LoginWeek1 == 0) $sql = "UPDATE achievements SET LoginWeek1 = 1 WHERE StudentID = ?";
            break;
        case 2:
            if ($obj->LoginWeek2 == 0) $sql = "UPDATE achievements SET LoginWeek2 = 1 WHERE StudentID = ?";
            break;
        case 3:
            if ($obj->LoginWeek3 == 0) $sql = "UPDATE achievements SET LoginWeek3 = 1 WHERE StudentID = ?";
            break;
        case 4:
            if ($obj->LoginWeek4 == 0) $sql = "UPDATE achievements SET LoginWeek4 = 1 WHERE StudentID = ?";
            break;
        case 5:
            if ($obj->LoginWeek5 == 0) $sql = "UPDATE achievements SET LoginWeek5 = 1 WHERE StudentID = ?";
            break;
        case 6:
            if ($obj->LoginWeek6 == 0) $sql = "UPDATE achievements SET LoginWeek6 = 1 WHERE StudentID = ?";
            break;
        case 7:
            if ($obj->LoginWeek7 == 0) $sql = "UPDATE achievements SET LoginWeek7 = 1 WHERE StudentID = ?";
            break;
        case 8:
            if ($obj->LoginWeek8 == 0) $sql = "UPDATE achievements SET LoginWeek8 = 1 WHERE StudentID = ?";
            break;
        case 9:
            if ($obj->LoginWeek9 == 0) $sql = "UPDATE achievements SET LoginWeek9 = 1 WHERE StudentID = ?";
            break;
        case 10:
            if ($obj->LoginWeek10 == 0) $sql = "UPDATE achievements SET LoginWeek10 = 1 WHERE StudentID = ?";
            break;
    }
    // if requiring updates
    if (isset($sql)) {
        $sql = $c->prepare($sql);
        $sql->execute(array($studentId));

        // fetch the latest version
        $obj = achGetAllAchievementsByStudentId($c, $studentId)[0];
        unset($sql);
    }

    // check master works
    if ($obj->LoginMaster == 0 // not achieved
        // put week 10 at the beginning to reduce the length of ands
        && $obj->LoginWeek10 && $obj->LoginWeek2 && $obj->LoginWeek3 && $obj->LoginWeek4 && $obj->LoginWeek5
        && $obj->LoginWeek6 && $obj->LoginWeek7 && $obj->LoginWeek8 && $obj->LoginWeek9 && $obj->LoginWeek1) {
        $sql = "UPDATE achievements SET LoginMaster = 1 WHERE StudentID = ?";
    }
    if (isset($sql)) {
        $sql = $c->prepare($sql);
        $sql->execute(array($studentId));
    }
}


// achieve "MasterGaming"
function achCheckAndSetMasterGaming(PDO $c, $studentId) {
    $obj = achGetAllAchievementsByStudentId($c, $studentId)[0];
    if ($obj->MasterGaming == 0 // not achieved
        && $obj->LaunchSportsNinja && $obj->PlayEveryGameModeSn && $obj->BeatScoreSnA && $obj->BeatScoreSnB && $obj->BeatScoreSnC
        && $obj->LaunchMealCrusher && $obj->PlayEveryGameModeMc && $obj->BeatScoreMcA && $obj->BeatScoreMcB && $obj->BeatScoreMcC) {
        // set MasterGaming
        $sql = "update achievements set MasterGaming = 1 where StudentID = ?";
        $sql = $c->prepare($sql);
        $sql->execute(array($studentId));
    }
}

// achieve "LaunchSportsNinja"
function achCheckAndSetLaunchSportsNinja(PDO $c, $studentId) {
}

// achieve "PlayEveryGameModeSn"
function achCheckAndSetPlayEveryGameModeSn(PDO $c, $studentId) {
}

// achieve "BeatScoreSnA"
function achCheckAndSetBeatScoreSnA(PDO $c, $studentId) {
}

// achieve "BeatScoreSnB"
function achCheckAndSetBeatScoreSnB(PDO $c, $studentId) {
}

// achieve "BeatScoreSnC"
function achCheckAndSetBeatScoreSnC(PDO $c, $studentId) {
}

// achieve "LaunchMealCrusher"
function achCheckAndSetLaunchMealCrusher(PDO $c, $studentId) {
}

// achieve "PlayEveryGameModeMc"
function achCheckAndSetPlayEveryGameModeMc(PDO $c, $studentId) {
}

// achieve "BeatScoreMcA"
function achCheckAndSetBeatScoreMcA(PDO $c, $studentId) {
}

// achieve "BeatScoreMcB"
function achCheckAndSetBeatScoreMcB(PDO $c, $studentId) {
}

// achieve "BeatScoreMcC"
function achCheckAndSetBeatScoreMcC(PDO $c, $studentId) {
}

// TODO: create partial logs for some of the achievements