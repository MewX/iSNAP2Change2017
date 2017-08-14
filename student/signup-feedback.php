<?php
    require_once('../mysql-lib.php');
    require_once('../debug.php');
    $pageName = "signup-feedback";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])){
        $action = $_POST["action"];
        if ($action == "VALIDTOKEN" && $_POST["token"]) {
            $token = $_POST["token"];
        } else if ($action == "VALIDUSERNAME" && $_POST["username"]) {
            $username = $_POST["username"];
        } else if ($action == "REGISTER"
            && $_POST["username"] && $_POST["password"] && $_POST["lastname"] && $_POST["firstname"] && $_POST["email"]
            && $_POST["dobDay"] && $_POST["dobMon"] && $_POST["dobYear"] && $_POST["gender"] && $_POST["identity"] && $_POST["classID"]
        ) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $lastname = $_POST["lastname"];
            $firstname = $_POST["firstname"];
            $email = $_POST["email"];
            $dobDay = $_POST["dobDay"];
            $dobMon = $_POST["dobMon"];
            $dobYear = $_POST["dobYear"];
            $gender = $_POST["gender"];
            $identity = $_POST["identity"];
            $classID = $_POST["classID"];
        } else {
            debug_log("Illegal state!");
            exit;
        }
    } else {
        debug_log("Illegal state!");
        header("location:welcome.php");
        exit;
    }

    $conn = null;

    try {
        $conn = db_connect();

        if($action == "VALIDTOKEN"){
            if(validToken($conn, $token)) {
                $feedback["result"] = "valid";
            } else {
                $feedback["result"] = "invalid";
            }
        }

        if($action == "VALIDUSERNAME"){
            if(checkStudentUsernameExisting($conn, $username)) {
                $feedback["result"] = "valid";
            } else {
                $feedback["result"] = "invalid";
            }
        }

        if($action == "REGISTER"){
            // check validation
            $dob = $dobYear."-".$dobMon."-".$dobDay;
            createStudent($conn, $username, $password, $firstname, $lastname, $email, $gender, $dob, $identity, $classID);
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
    $feedback["message"] = "success";
    echo json_encode($feedback);
