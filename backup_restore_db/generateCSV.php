<?php
function generateStudentDemography($conn, &$header, &$data){
    $sql = "SELECT StudentID, FirstName, LastName, Gender, DOB, Identity as Country, QuizScore, ClassName, 
            MAX(IF(gameID=1,gameScore,null)) as FruitNinja, 
            MAX(IF(gameID=2,gameScore,null)) as CandyCrush from 
            (SELECT FirstName, LastName, student.StudentID, Gender, DOB, Identity, student.Score as QuizScore, ClassName, sum(game_record.score) as gameScore, gameID 
              FROM student NATURAL JOIN Class LEFT JOIN game_record on student.StudentID = game_record.StudentID 
              group BY gameID, student.StudentID order BY student.StudentID
            ) as temp GROUP BY StudentID;";
    $Query = $conn->prepare($sql);
    $Query->execute();
    $result = $Query->fetchAll();
    $total_column = $Query->columnCount();

    for ($counter = 0; $counter < $total_column; $counter ++) {
        $meta = $Query->getColumnMeta($counter);
        $header .= '"' . $meta['name'] . '",';
    }
    $header .= "\n";
    for($i = 0; $i < count($result); $i++){
        for($j = 0; $j<count($result[$i])/2; $j++){
            $data .= '"' . $result[$i][$j] . '",';
        }
        $data .= "\t\n";
    }
}

function generateQuizProcess($conn, &$header, &$data){
    $columnName = array('ClassName', 'FirstName', 'LastName');
    $colspanName = array('');
    $quizList = array('ClassName', 'FirstName', 'LastName');
    $getQuizWithWeek = getQuizWithWeek($conn);
    $getQuizInfo = getQuizInfo($conn);
    $studentStatistic = getStudentsStatistic($conn);
    $startColumn = 1;
    for ($i = 0; $i < count($getQuizWithWeek); $i++){
        $j = $i+1;
        array_push($colspanName, "Week$j");
    }
    for ($i = 1; $i <= count($getQuizInfo); $i++){
        array_push($columnName,"Quiz$i");
    }
    for ($i = 0; $i < count($getQuizInfo); $i++){
        $j = $getQuizInfo[$i]->QuizID;
        array_push($quizList,"Quiz$j");
    }
    $header .= ", , , ,";
    for ($i = 1; $i< count($colspanName); $i++){
        for($j = 0; $j<$getQuizWithWeek[$i-1]->QuizNum; $j++){
            $header .= '"Week-' . $getQuizWithWeek[$i-1]->Week . '",';
        }
    }
    $header .= "\n";
    $header .= "StudentID,Class Name,FirstName, LastName,";
    for ($i = $startColumn+2; $i < count($columnName); $i++){
        $header .= '"' . $getQuizInfo[$i-3]->QuizName . '-' . $getQuizInfo[$i-3]->QuizType . '",';
    }
    $header .= "\n";
    for ($i = 0; $i < count($studentStatistic); $i++) {
        $data .= '"' . $studentStatistic[$i]->StudentID . '",';
        $data .= '"' . $studentStatistic[$i]->ClassName . '",';
        for ($j = $startColumn; $j < count($quizList); $j++) {
            if($studentStatistic[$i]->$quizList[$j] == "GRADED"){
                $grading = str_replace("Quiz","Grading", $quizList[$j]);
                $data .= '"' . $studentStatistic[$i]->$grading . '",';
            }else if($studentStatistic[$i]->$quizList[$j] == "UNGRADED"){
                $data .= '"' . 'UNGRADED' . '",';
            }else if($studentStatistic[$i]->$quizList[$j] == "UNSUBMITTED" || $studentStatistic[$i]->$quizList[$j]==""){
                $data .= '"' . 'UNSUBMITTED' . '",';
            }else{
                $data .= '"' . $studentStatistic[$i]->$quizList[$j] . '",';
            }
        }
        $data .= "\t\n";
    }
}

function generateAchievements($conn, &$header, &$data){
    $sql = "select StudentID,FirstName, LastName,Classname,QuizMaster,AllSnapFacts,ResourcePage,QuizLeaderBoardTopTenOnce,LearningFromMistakes,HeadOfClass,WeeklyGenius,GotItRight,Aced,HatTrick,MasterExtraContent,LoginMaster,LoginWeek1,LoginWeek2,LoginWeek3,LoginWeek4,LoginWeek5,LoginWeek6,LoginWeek7,LoginWeek8,LoginWeek9,LoginWeek10,MasterGaming,LaunchSportsNinja,PlayEveryGameModeSn,BeatScoreSnA,BeatScoreSnB,BeatScoreSnC,LaunchMealCrusher,PlayEveryGameModeMc,BeatScoreMcA,BeatScoreMcB,BeatScoreMcC 
            from achievements NATURAL JOIN Student NATURAL JOIN Class;";
    $sql = $conn->prepare($sql);
    $sql->execute();
    $result = $sql->fetchAll();
    $total_column = $sql->columnCount();

    for ($counter = 0; $counter < $total_column; $counter ++) {
        $meta = $sql->getColumnMeta($counter);
        $header .= '"' . $meta['name'] . '",';
    }
    $header .= "\n";
    for($i = 0; $i < count($result); $i++){
        for($j = 0; $j<count($result[$i])/2; $j++){
            $data .= '"' . $result[$i][$j] . '",';
        }
        $data .= "\t\n";
    }
    $data .= "1 stands for achieve and 0 stands for not achieve";
}

function generateStudyTime($conn, &$header, &$data){
    $sql = "select Student.StudentID,FirstName, LastName, Classname";
    for($i=1;$i<=10;$i++){
        $sql .= ", MAX(IF(Week=".$i.",TimeSpent,null)) as Week".$i;
    }
    $sql .= " from Student Left JOIN Student_week_record ON Student.StudentID = Student_week_record.StudentID NATURAL JOIN class GROUP BY Student.StudentID;";
    $sql = $conn->prepare($sql);
    $sql->execute();

    $result = $sql->fetchAll();
    $total_column = $sql->columnCount();

    for ($counter = 0; $counter < $total_column; $counter ++) {
        $meta = $sql->getColumnMeta($counter);
        $header .= '"' . $meta['name'] . '",';
    }
    $header .= "\n";
    for($i = 0; $i < count($result); $i++){
        for($j = 0; $j<count($result[$i])/2; $j++){
            $data .= '"' . $result[$i][$j] . '",';
        }
        $data .= "\t\n";
    }
}

require_once ("../mysql-lib.php");
$conn = db_connect();
$csvFileName = $_GET['fileName'].".csv";
$sql = "";
$header = "";
$data = "";
if($csvFileName == "student demography.csv"){
    generateStudentDemography($conn, $header, $data);
}else if($csvFileName == "quiz process.csv"){
    generateQuizProcess($conn, $header, $data);
}else if($csvFileName == "survey result.csv"){

}else if($csvFileName == "achievements.csv") {
    generateAchievements($conn, $header, $data);
}else if($csvFileName == "studyTime.csv") {
    generateStudyTime($conn, $header, $data);
}

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csvFileName);
$output = $header . $data;
echo $output;
exit;
?>
