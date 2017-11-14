<?php

	session_start();

	require_once('../mysql-lib.php');
    require_once("../achievement-lib.php");
	require_once('../debug.php');
	$pageName = "login";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    	$username = $_POST["username"];
    	$password = $_POST["password"];
    } else {
    	$feedback["result"] = "invalid";
    }

	$conn = null;
	try {
		$conn = db_connect();

		//valid student
		$validRes = validStudent($conn, $username, $password);
		if($validRes != null) {
		    if($validRes != 'expired') {
                $feedback["result"] = "valid";
                $_SESSION["studentID"] = $validRes['StudentID'];
                $_SESSION["studentUsername"] = $validRes['Username'];
                $feedback["message"] = "success";

                // ensure that the student has a record in achievement table
                if (!achCheckRecordExistence($conn, $_SESSION["studentID"])) {
                    achCreateNewRecord($conn, $_SESSION["studentID"]);
                }
            }else{
                $feedback["result"] = "expired";
            }

		} else {
			$feedback["result"] = "invalid";
		}
	} catch(Exception $e) {
		if($conn != null) {
			db_close($conn);
		}

		debug_err($e);
		$feedback["message"] = $e->getMessage();
		echo json_encode($feedback);
		exit;
	}

	db_close($conn);
	echo json_encode($feedback);
