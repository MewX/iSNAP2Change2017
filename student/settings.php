<?php

    //check login status
    require_once('./student-validation.php');

    require_once("../mysql-lib.php");
    require_once("../debug.php");
    $pageName = "settings";

    $conn = null;

    try{
        $conn = db_connect();

        //get student account information
        $studentInfo = getStudent($conn, $studentID);

    } catch(Exception $e) {
        if($conn != null) {
            db_close($conn);
        }

        debug_err($e);
        //to do: handle sql error
        //...
        exit;
    }

    db_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no">
    <title>Setting | SNAP²</title>
    <link href='https://fonts.googleapis.com/css?family=Maitree|Lato:400,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" type="text/css" href="./css/vendor/animate.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <script src="./js/vendor/wow.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <style>
        .setting-content {
            max-width: 1000px;
            margin: 30px auto;
            text-align: center;
        }
        .setting-logo {
            width: 128px;
            height: 128px;
            margin: 0 auto 20px;
            background-size: 100% 100%;
            background-image: url("./img/settings_icon.png");
        }
        .setting-label {
            font-size: 28px;
        }
        .setting-prompt {
            font-size: 18px;
            font-family: Maitree, serif;
        }

        .account-info {
            max-width: 700px;
            margin: 0 auto;
        }
        .account-title {
            margin: 30px 0;
            font-size: 20px;

        }
        .addition-info {
            max-width: 600px;
            margin: 40px auto;
        }
        .addition-title {
            text-align: center;
            margin: 0 auto 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <? require("./top-nav-bar.php") ?>

    <div class="content-wrapper" style="min-height: calc(100% - 120px)">
        <div class="setting-content">
            <div class="setting-header">
                <div class="setting-logo"></div>
                <div class="setting-label p1" style="color: white">Settings</div>
                <div class="setting-prompt p1" style="color: white">Change your account settings</div>
            </div>
            <div class="account-info">
                <h2 class="account-title" style="color: white">Account Information</h2>

                <form class="form-horizontal" id="update-form">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="username" style="color: #FCEE2D">Username:</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="username" placeholder="Enter username" value="<?php echo $studentInfo->Username?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email" style="color: #FCEE2D">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo $studentInfo->Email?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="firstname" style="color: #FCEE2D">First name:</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="firstname" placeholder="Enter first name" value="<?php echo $studentInfo->FirstName?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="lastname" style="color: #FCEE2D">Last name:</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="lastname" placeholder="Enter last name" value="<?php echo $studentInfo->LastName?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="dob" style="color: #FCEE2D">Date Of Birth (YYYY-MM-DD): </label>
                        <div class="col-sm-8">
<!--                            TODO: Fix this date format into DD/MM/YYYY-->
                            <input type="date" class="form-control" id="dob" placeholder="Date of Birth" value="<? echo $studentInfo->DOB ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="gender" style="color: #FCEE2D">Gender:</label>
                        <div class="col-sm-8">
                            <div class="input-group" id="gender">
                                <label class="radio-inline">
                                    <input type="radio" name="gender-radio" id="inlineRadio1" value="Male" <? if ($studentInfo->Gender === "Male") echo "checked" ?>><span style="color: white">Male</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender-radio" id="inlineRadio2" value="Female"<? if ($studentInfo->Gender === "Female") echo "checked" ?>><span style="color: white;">Female</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="identity" style="color: #FCEE2D">Country:</label>
                        <div class="col-sm-8">
                            <div class="input-group" id="identity">
                                <select id="identity-selection" class="form-control">
                                    <option <? if ($studentInfo->Identity === "AU - Australia") echo "selected=\"selected\"" ?>>AU - Australia</option>
                                    <option <? if ($studentInfo->Identity === "AT - Austria") echo "selected=\"selected\"" ?>>AT - Austria</option>
                                    <option <? if ($studentInfo->Identity === "BE - Belgium") echo "selected=\"selected\"" ?>>BE - Belgium</option>
                                    <option <? if ($studentInfo->Identity === "BR - Brazil") echo "selected=\"selected\"" ?>>BR - Brazil</option>
                                    <option <? if ($studentInfo->Identity === "CA - Canada") echo "selected=\"selected\"" ?>>CA - Canada</option>
                                    <option <? if ($studentInfo->Identity === "CH - Switzerland") echo "selected=\"selected\"" ?>>CH - Switzerland</option>
                                    <option <? if ($studentInfo->Identity === "CN - China") echo "selected=\"selected\"" ?>>CN - China</option>
                                    <option <? if ($studentInfo->Identity === "CO - Colombia") echo "selected=\"selected\"" ?>>CO - Colombia</option>
                                    <option <? if ($studentInfo->Identity === "CZ - Czech Republic") echo "selected=\"selected\"" ?>>CZ - Czech Republic</option>
                                    <option <? if ($studentInfo->Identity === "DE - Germany") echo "selected=\"selected\"" ?>>DE - Germany</option>
                                    <option <? if ($studentInfo->Identity === "ES - Spain") echo "selected=\"selected\"" ?>>ES - Spain</option>
                                    <option <? if ($studentInfo->Identity === "FI - Finland") echo "selected=\"selected\"" ?>>FI - Finland</option>
                                    <option <? if ($studentInfo->Identity === "FR - France") echo "selected=\"selected\"" ?>>FR - France</option>
                                    <option <? if ($studentInfo->Identity === "GB - United Kingdom") echo "selected=\"selected\"" ?>>GB - United Kingdom</option>
                                    <option <? if ($studentInfo->Identity === "HK - Hong Kong") echo "selected=\"selected\"" ?>>HK - Hong Kong</option>
                                    <option <? if ($studentInfo->Identity === "IN - India") echo "selected=\"selected\"" ?>>IN - India</option>
                                    <option <? if ($studentInfo->Identity === "IO - British Indian Ocean Territory") echo "selected=\"selected\"" ?>>IO - British Indian Ocean Territory</option>
                                    <option <? if ($studentInfo->Identity === "IT - Italy") echo "selected=\"selected\"" ?>>IT - Italy</option>
                                    <option <? if ($studentInfo->Identity === "JP - Japan") echo "selected=\"selected\"" ?>>JP - Japan</option>
                                    <option <? if ($studentInfo->Identity === "KE - Kenya") echo "selected=\"selected\"" ?>>KE - Kenya</option>
                                    <option <? if ($studentInfo->Identity === "KH - Cambodia") echo "selected=\"selected\"" ?>>KH - Cambodia</option>
                                    <option <? if ($studentInfo->Identity === "MX - Mexico") echo "selected=\"selected\"" ?>>MX - Mexico</option>
                                    <option <? if ($studentInfo->Identity === "MY - Malaysia") echo "selected=\"selected\"" ?>>MY - Malaysia</option>
                                    <option <? if ($studentInfo->Identity === "NL - Netherlands") echo "selected=\"selected\"" ?>>NL - Netherlands</option>
                                    <option <? if ($studentInfo->Identity === "NO - Norway") echo "selected=\"selected\"" ?>>NO - Norway</option>
                                    <option <? if ($studentInfo->Identity === "NZ - New Zealand") echo "selected=\"selected\"" ?>>NZ - New Zealand</option>
                                    <option <? if ($studentInfo->Identity === "PG - Papua New Guinea") echo "selected=\"selected\"" ?>>PG - Papua New Guinea</option>
                                    <option <? if ($studentInfo->Identity === "PH - Philippines") echo "selected=\"selected\"" ?>>PH - Philippines</option>
                                    <option <? if ($studentInfo->Identity === "PK - Pakistan") echo "selected=\"selected\"" ?>>PK - Pakistan</option>
                                    <option <? if ($studentInfo->Identity === "PL - Poland") echo "selected=\"selected\"" ?>>PL - Poland</option>
                                    <option <? if ($studentInfo->Identity === "RU - Russia") echo "selected=\"selected\"" ?>>RU - Russia</option>
                                    <option <? if ($studentInfo->Identity === "SE - Sweden") echo "selected=\"selected\"" ?>>SE - Sweden</option>
                                    <option <? if ($studentInfo->Identity === "SG - Singapore") echo "selected=\"selected\"" ?>>SG - Singapore</option>
                                    <option <? if ($studentInfo->Identity === "TH - Thailand") echo "selected=\"selected\"" ?>>TH - Thailand</option>
                                    <option <? if ($studentInfo->Identity === "TW - Taiwan") echo "selected=\"selected\"" ?>>TW - Taiwan</option>
                                    <option <? if ($studentInfo->Identity === "TZ - Tanzania") echo "selected=\"selected\"" ?>>TZ - Tanzania</option>
                                    <option <? if ($studentInfo->Identity === "US - United States") echo "selected=\"selected\"" ?>>US - United States</option>
                                    <option <? if ($studentInfo->Identity === "VN - Vietnam") echo "selected=\"selected\"" ?>>VN - Vietnam</option>
                                    <option <? if ($studentInfo->Identity === "Others") echo "selected=\"selected\"" ?>>Others</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="oldpass" style="color: #FCEE2D">Old password for verification:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="oldpass" placeholder="Enter old password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="newpass" style="color: #FCEE2D">New password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="newpass" placeholder="Enter new password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="newpass2" style="color: #FCEE2D">New password again:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="newpass2" placeholder="Enter new password again">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button class="btn btn-default">Update</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="addition-info">
<!--                TODO: Add a link to notification centre-->
                <div class="addition-title p1" style="color: white">Any issues of questions?<br/>Please contact the researcher in your notification centre.</div>
            </div>
        </div>

    </div>

    <ul class="sitenav">
        <li class="sitenav-item sitenav-game-home"><a href="games.php" data-toggle="tooltip" title="Game Home"></a></li>
        <li class="sitenav-item sitenav-extra-activities"><a href="extra-activities.php" data-toggle="tooltip" title="Extra Activities"></a></li>
        <li class="sitenav-item sitenav-progress"><a href="progress.php" data-toggle="tooltip" title="Progress"></a>
        <li class="sitenav-item sitenav-reading-material"><a href="reading-material.php" data-toggle="tooltip" title="Reading Materials"></a></li>
    </ul>

    <div class="footer-wrapper">
        <div class="footer">
            <div class="footer-content">
                <a href="#" class="footer-logo"></a>
                <ul class="footer-nav">
                    <li class="footer-nav-item"><a href="#">Any Legal Stuff</a></li>
                    <li class="footer-nav-item"><a href="#">Acknowledgements</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<script>
    function submitChanges() {
        var username = $('#username').val();
        var email = $('#email').val();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var dob = $('#dob').val();
        var gender = $("input[type='radio'][name='gender-radio']:checked").val();
        var identity = $('#identity-selection').val();

        var oldpass = $('#oldpass').val();
        var newpass = $('#newpass').val();
        var newpass2 = $('#newpass2'); // get object

        // new password detection
        if (newpass2.val() !== newpass) {
            alert("Two new passwords were not the same! Please try again!");
            newpass2.val("");
            return;
        }

        // convert dob into YYYY-MM-DD
        if (dob.match(/^\d\d\/\d\d\/\d\d\d\d$/) !== null) {
            var d = new Date(dob);
            if ( !!d.valueOf() ) { // Valid date
                year = d.getFullYear();
                month = d.getMonth();
                day = d.getDate();
            }
            dob = year + "-" + month + "-" + day;
        }
        if (dob.match(/^\d\d\d\d-\d\d-\d\d$/) === null) {
            alert("Date of birth format was invalid!");
            return;
        }

        var obj = {
            name: username,
            email: email,
            firstname: firstname,
            lastname: lastname,
            dob: dob,
            gender: gender,
            identity: identity,

            oldpass: oldpass,
            newpass: newpass
        };

        $.ajax({
            // NOTE: This is not save enough by transferring plain password
            // Though, this is an old system issue, not just in this code
            url: "settings-feedback.php",
            data: obj,
            type: "POST",
            dataType: "json"
        })
        .done(function (feedback) {
            if(feedback.message !== "success") {
                alert(feedback.message + ". Please try again!");
            } else {
                $('#oldpass').val("");
                $('#newpass').val("");
                $('#newpass2').val("");
                alert("Successfuly updated!");
            }
        })
        .fail(function (xhr, status, errorThrown) {
            alert("Sorry, there was a problem! Please try again later.");
            console.log("Error: " + errorThrown);
            console.log("Status: " + status);
            console.dir(xhr);
        });
    }

    function processForm(e) {
        if (e.preventDefault) e.preventDefault();
        submitChanges();
        return false;
    }

    var form = document.getElementById('update-form');
    if (form.attachEvent) {
        form.attachEvent("submit", processForm);
    } else {
        form.addEventListener("submit", processForm);
    }
</script>
</body>
</html>



