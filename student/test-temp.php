<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 7/16/2017
 * Time: 09:38 PM
 */

require '../mysql-lib.php';

$conn = db_connect();
echo strtolower("Todd\n");
//var_dump(checkStudentUsernameExisting($connection, 'todd'));
//var_dump(validStudent($connection, 'Todd', 'ISNAP'));

$quizID = createQuiz($conn, 3, 'Calculator', 1);
createMiscSection($conn, $quizID, 12, 'Calculator');
