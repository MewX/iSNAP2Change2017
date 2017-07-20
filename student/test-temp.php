<?php
/**
 * Created by PhpStorm.
 * User: MewX
 * Date: 7/16/2017
 * Time: 09:38 PM
 */

require '../mysql-lib.php';

$connection = db_connect();
echo strtolower("Todd\n");
//var_dump(checkStudentUsernameExisting($connection, 'todd'));
var_dump(validStudent($connection, 'Todd', 'ISNAP'));
