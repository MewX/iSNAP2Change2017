<?php
require_once ("../mysql-lib.php");
$conn = db_connect();
$csvFileName = $_GET['fileName'].".csv";
$sql = "";
$header = "";
$data = "";
if($csvFileName == "student demography.csv"){
    //$sql = "SELECT StudentID, Gender, DOB, Identity, Score as QuizScore, ClassName FROM Student NATURAL JOIN Class;";
    $sql = "SELECT StudentID, Gender, DOB, Identity as Country, QuizScore, ClassName, 
            MAX(IF(gameID=1,gameScore,null)) as FruitNinja, 
            MAX(IF(gameID=2,gameScore,null)) as CandyCrush from 
            (SELECT student.StudentID, Gender, DOB, Identity, student.Score as QuizScore, ClassName, sum(game_record.score) as gameScore, gameID 
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
}else if($csvFileName == "quiz process.csv"){
    $columnName = array('ClassName', 'FirstName', 'LastName');
    $colspanName = array('');
    $quizList = array('ClassName', 'FirstName', 'LastName');
    $getQuizWithWeek = getQuizWithWeek($conn);
    $getQuizInfo = getQuizInfo($conn);
    $studentStatistic = getStudentsStatistic($conn);
    $startColumn = 3;
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
    $header .= ", ,";
    for ($i = 1; $i< count($colspanName); $i++){
        for($j = 0; $j<$getQuizWithWeek[$i-1]->QuizNum; $j++){
            $header .= '"Week-' . $getQuizWithWeek[$i-1]->Week . '",';
        }
    }
    $header .= "\n";
    $header .= "StudentID,Class Name,";
    for ($i = 3; $i < count($columnName); $i++){
        $header .= '"' . $columnName[$i] . '-' . $getQuizInfo[$i-3]->QuizType . '",';
    }
    $header .= "\n";
    for ($i = 0; $i < count($studentStatistic); $i++) {
        $data .= '"' . $studentStatistic[$i]->StudentID . '",';
        $data .= '"' . $studentStatistic[$i]->ClassName . '",';
        for ($j = 3; $j < count($quizList); $j++) {
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
}else if($csvFileName == "survey result.csv"){

}


header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$csvFileName);
$output = $header . $data;
echo $output;
exit;
?>
