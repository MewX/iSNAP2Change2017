<?php

	session_start();

	require_once('../mysql-lib.php');
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

		// TODO: ensure that the student has a record in achievement table

		// TODO: add achievement manager here

		if($validRes != null) {
			$feedback["result"] = "valid";
			$_SESSION["studentID"] = $validRes['StudentID'];
			$_SESSION["studentUsername"] = $validRes['Username'];
            $feedback["message"] = "success";
		} else {
			$feedback["result"] = "invalid";
            $feedback["message"] = "Failed";
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
