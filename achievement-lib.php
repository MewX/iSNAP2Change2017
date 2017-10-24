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

}

// TODO: create partial logs for some of the achievements