<?php
require_once("../mysql-lib.php");
require_once("../achievement-lib.php");

$NOJUMP = true;
require('student-validation.php');

/**
 * POST the request in the following way.
 *
 * 1. Query history best scores:
 * JSON Object:
 * {
 * type: "history",
 * gameid: 1
 * }
 *
 * Return value would be an array:
 * {
 * message: "success", // "success" or other messages
 * data: [{
 * level: 1,
 * score: 20
 * },
 * {
 * level: 5,
 * score: 10
 * }, ...]
 * }
 *
 *
 * 2. Submit new score for a certain level
 * {
 * type: "submit",
 * gameid: 1,
 * level: 5,
 * score: 123 // the current score
 * }
 *
 * Response data would be;
 * {
 * message: "success", // "success" or other messages
 * }
 *
 *
 * 3. Query ranking list for one level
 * (not providing the ranking list for total score because it can be queried from website)
 * {
 * type: "ranking",
 * gameid: 1,
 * level: 1,
 * num: 10 // (optional) the number of ranking records requested, default is "10"
 * }
 *
 * Response data should be:
 * {
 * message: "success", // "success" or other messages
 * data: [{
 * name: Todd
 * ranking: 2
 * score: 123
 * }, ...]
 * }
 */

$conn = db_connect();

$data = json_decode(file_get_contents('php://input'), true);

$output = new stdClass();

if (!isset($studentID)) {
    $output->message = "Not logged in.";
} else if ($data == null || !isset($data['type'])) {
    BAD:
    $output->message = "Request invalid! " . $data;
} else {
    // update game launch achievement
    if (!isset($data["gameid"])) goto BAD;
    $gameid = $data["gameid"];
    $gameInfo = getGame($conn, $gameid); // the record object
    if ($gameInfo == null) goto BAD;
    $gameTotalLevel = $gameInfo->Levels;
    $gameName = strtolower($gameInfo->Description);

    // find which game and set achievement
    define('NINJA_KW', 'ninja');
    define('CRUSH_KW', 'crush');
    if (strpos($gameName, NINJA_KW) !== false) {
        achCheckAndSetLaunchSportsNinja($conn, $studentID);
    } else if (strpos($gameName, CRUSH_KW) !== false) {
        achCheckAndSetLaunchMealCrusher($conn, $studentID);
    }

    // main logic
    if ($data["type"] == "history") {
        // query user history score
        $ret = getStudentGameScores($conn, $gameid, $studentID);
        $outHistory = array();
        foreach ($ret as $i => $score) {
            $temp = new stdClass();
            $temp->level = $i;
            $temp->score = $score;
            array_push($outHistory, $temp);
        }
        $output->data = $outHistory;
        $output->weekunlocked = getStudentClassWeek($conn, $studentID);
        $output->message = "success";
    } else if ($data['type'] == "submit") {
        // submit new score
        if (!isset($data["level"]) || !isset($data["score"])) goto BAD;
        $level = $data["level"];
        $score = $data["score"];
        $ret = updateStudentGameScores($conn, $gameid, $studentID, $level, $score);
        if ($ret) {
            $output->message = "success";

            // update achievements
            if (strpos($gameName, NINJA_KW) !== false) {
                achCheckAndSetPlayEveryGameModeSn($conn, $gameid, $studentID, $gameTotalLevel);
                achCheckAndSetBeatScoreSn($conn, $gameid, $studentID);
            } else if (strpos($gameName, CRUSH_KW) !== false) {
                achCheckAndSetPlayEveryGameModeMc($conn, $gameid, $studentID, $gameTotalLevel);
                achCheckAndSetBeatScoreMc($conn, $gameid, $studentID);
            }
        } else {
            $output->message = "Updating score failed!";
        }
    } else if ($data['type'] == "ranking") {
        // get ranking
        if (!isset($data["level"])) goto BAD;
        $level = $data["level"];
        $num = isset($data["num"])? $data["num"] : 10; // default limit is 10
        $ret = getGameLevelRanking($conn, $gameid, $level, $num);

        $outHistory = array();
        for ($i = 0; $i < count($ret); $i ++) {
            $temp = new stdClass();
            $temp->ranking = $i + 1;
            $temp->name = $ret[$i]["Username"];
            $temp->score = $ret[$i]["Score"];
            array_push($outHistory, $temp);
        }
        $output->data = $outHistory;
        $output->message = "success";
    } else {
        $output->message = "Unknown request: " . $data["type"];
    }
}

echo json_encode($output);
