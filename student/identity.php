<?php
/**
 * This file is used for detecting user detail.
 */

session_start();

$NOJUMP = true;
require_once('./student-validation.php');

echo "id: $studentID; name: $studentUsername";
