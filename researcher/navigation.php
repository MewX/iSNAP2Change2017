<?php
require_once('researcher-validation.php');
require_once("../mysql-lib.php");
require_once("../debug.php");
require_once("researcher-lib.php");
try {
    $conn = db_connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $update = $_POST['update'];
        if ($update == 0) {
            // update
            $userName = $_POST['Username'];
            $password = $_POST['Password'];
            $researcherID = $_POST['ResearcherID'];
            updateResearcher($conn, $userName, $password, $researcherID);
            $currentUserId = $_SESSION["researcherID"];
        }
    }

} catch (Exception $e) {
    debug_err($e);
}

try {
    refreshAllStudentsScore($conn);
    $studentResult = getStudents($conn);
    $classResult = getClasses($conn);
    $currentUsername = $_SESSION["researcherUsername"];
    $currentUserId = $_SESSION["researcherID"];

} catch (Exception $e) {
    debug_err($e);
}

db_close($conn);
?>
<?php require_once('header-lib.php'); ?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0"
     xmlns="http://www.w3.org/1999/html">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.php">iSNAP2Change Administration System</a>
    </div>
    <!-- /.navbar-header -->
    <?php if (isset($_SESSION['researcherID']) && isset($_SESSION['researcherUsername'])): ?>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <!--
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                <em>Yesterday</em>
                            </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                <em>Yesterday</em>
                            </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                <em>Yesterday</em>
                            </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>Read All Messages</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                -->
            </ul>
            <!-- /.dropdown-messages -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-tasks">
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 1</strong>
                                <span class="pull-right text-muted">40% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 2</strong>
                                <span class="pull-right text-muted">20% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    <span class="sr-only">20% Complete</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 3</strong>
                                <span class="pull-right text-muted">60% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <p>
                                <strong>Task 4</strong>
                                <span class="pull-right text-muted">80% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    <span class="sr-only">80% Complete (danger)</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Tasks</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-tasks -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> Researchers have replied to your question!
                            <span class="pull-right text-muted small">View it</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-check fa-fw"></i> Your short answer quiz has been graded!
                            <span class="pull-right text-muted small">View it</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-check fa-fw"></i> Your infograph quiz has been graded!
                            <span class="pull-right text-muted small">View it</span>
                        </div>
                    </a>
                </li>

                <!--
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> New Comment
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                            <span class="pull-right text-muted small">12 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-envelope fa-fw"></i> Message Sent
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-tasks fa-fw"></i> New Task
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                -->
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="../student/welcome.php"><i class="fa fa-home fa-fw"></i> Home</a>
                </li>
                <li><a data-toggle="modal" href="#updateProfile" id="settings"><i class="fa fa-user fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <?php if (isset($_SESSION['researcherID']) && isset($_SESSION['researcherUsername'])): ?>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                <?php else: ?>
                    <li><a data-toggle="modal" href="#myModal"><i class="fa fa-sign-out fa-fw"></i> Login</a></li>
                <? endif; ?>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <? endif; ?>
    <!-- /.navbar-top-links -->
    <?php if (isset($_SESSION['researcherID']) && isset($_SESSION['researcherUsername'])): ?>

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="index.php"><i class="fa fa-desktop fa-fw"></i> Dashboard<span class="fa arrow"></span></a>
                </li>
                <!-- Only visible to super account-->
                <?php if ($_SESSION['researcherID']==1): ?>
                    <li>
                        <a href="account.php"><i class="fa fa-archive" aria-hidden="true"></i> Account Administration<span class="fa arrow"></span></a>
                    </li>
                <? endif; ?>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#userAdmin" class=""
                       aria-expanded="true"><i class="fa fa-fw fa-wrench"></i> User Administration <i
                            class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="userAdmin" class="collapse in nav nav-second-level" aria-expanded="true">

                        <?php for ($i = 0; $i < count($userAdminPageArr); $i++) { ?>
                            <li>
                                <a href="<?php echo strtolower($userAdminPageArr[$i]); ?>.php"><i
                                        class="fa fa-fw fa-<?php echo $userAdminIconArr[$i]; ?>"></i>&nbsp;<?php echo $userAdminPageArr[$i]; ?>
                                    Overview</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!--/.nav-second-level -->
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#contentAdmin" class=""
                       aria-expanded="true"><i class="fa fa-fw fa-wrench"></i> Content Administration <i
                            class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="contentAdmin" class="collapse in nav nav-second-level" aria-expanded="true">
                        <?php for ($i = 0; $i < count($contentAdminPageArr); $i++) { ?>
                            <li>
                                <a href="<?php echo str_replace(" ", "-", strtolower($contentAdminPageArr[$i])); ?>.php">
                                    <!--overview icon-->
                                    <i class="fa fa-fw fa-<?php echo $contentAdminIconArr[$i]; ?>"></i>
                                    <!--overview name-->
                                    &nbsp;<?php echo $contentAdminPageArr[$i];
                                    if (in_array($contentAdminPageArr[$i], $quizTypeArr)) echo " Quiz" ?> Overview</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!--/.nav-second-level -->
                </li>
                <li>
                    <a href="javascript:" data-toggle="collapse" data-target="#gradingPage" class=""
                       aria-expanded="true"><i class="fa fa-fw fa-comment"></i> Grading & Feedback <i
                            class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="gradingPage" class="collapse in nav nav-second-level" aria-expanded="true">
                        <?php for ($i = 0; $i < count($gradingPageArr); $i++) { ?>
                            <li>
                                <a href="<?php echo str_replace(" ", "-", strtolower($gradingPageArr[$i])); ?>.php"><i
                                        class="fa fa-fw fa-<?php echo $gradingIconArr[$i]; ?>"></i>&nbsp;<?php echo $gradingPageArr[$i]; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!--/.nav-second-level -->
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
    <? endif; ?>

</nav>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <span id="login-fail-text" style="color:red"></span>
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">
                        <label><b>Username</b></label>
                        <input class="form-control" type="text" placeholder="Enter Username" id="username" required>
                        <br>
                        <label><b>Password</b></label>
                        <input class="form-control" type="password" placeholder="Enter Password" id="password" required>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" onclick="login()">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember" id="remember">
                    Remember me
                </label>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

            <?php
            if(isset($_COOKIE['username']) and isset($_COOKIE['password'])){
                $username = $_COOKIE['username'];
                $pass = $_COOKIE['password'];
                echo "<script>
                    document.getElementById('username').value = '$username';
                    document.getElementById('password').value = '$password';
                </script>";
            }
            ?>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateProfile" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="dialogTitle">Settings</h4>
            </div>
            <div class="modal-body">
                <form id="profileSubmission" method="post" action="
                <?php
                    if($_SERVER['PHP_SELF']!="/researcher/statistics.php"){
                        echo $_SERVER['PHP_SELF'];
                    } else{
                        echo "navigation.php";
                    }
                ?>">
                    <!--if 1, insert; else if 0 update; else if -1 delete;-->
                    <input type=hidden name="update" id="updateInfo" value="1">
                    <label for="ResearcherID" style="display:none">ResearcherID</label>
                    <input type="text" class="form-control newInfo" id="ResearcherID" name="ResearcherID"
                           style="display:none">
                    <span id='Umessage'></span>
                    <label for="Username">Username</label>
                    <input type="text" class="form-control newInfo" id="Username" name="Username" readonly>
                    <br>
                    <label for="Password">Password</label>
                    <input type="password" class="form-control newInfo" id="Password" name="Password">
                    <br>
                    <label for="cPassword">Confirmed Password</label>
                    <br>
                    <span id='message'></span>
                    <input type="password" class="form-control newInfo" id="cPassword" name="cPassword">
                    <br>
                    <div class="alert alert-danger">
                        <p><strong>Reminder</strong> : Username of researcher should be unique and no duplicate names are allowed.
                        </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveChange" class="btn btn-default" name="save">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('sb-admin-lib.php'); ?>

<script>
    function login() {
        var username = $('#username').val();
        var password = $('#password').val();
        var remember = $('#remember').val();

        var params = {
            type: "POST",
            dataType: "json",
            url: "login.php"
        }
        if($('#remember').is(':checked')){
            params.data = {
                username: username,
                password: password,
                remember: remember
            }
        }else{
            params.data = {
                username: username,
                password: password
            }
        }
        $.ajax(params)
        .done(function(feedback) {
            parseFeedback(feedback);
        })
        .fail(function( xhr, status, errorThrown ) {
            alert( "Please try again later" );
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
        });
    }

    function saveSetting(){
        var username = $('#Username').val();
        var password = $('#Password').val();
        var update = 0;
        var params = {
            type: "POST",
            dataType: "json",
            url: "navigation.php",
            data: {
                username: username,
                password: password,
                update: update
            }
        }
        $.ajax(params)
        .done(function(feedback) {
            parseFeedback(feedback);
        })
        .fail(function( xhr, status, errorThrown ) {
            alert( "Please try again later" );
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
        });
    }

    function parseFeedback(feedback) {
        if(feedback.message != "success"){
            alert(feedback.message + ". Please try again!");
            return;
        }

        if(feedback.result == "valid"){
            location.href = 'index.php';
        } else {
            $('#login-fail-text').text("Invalid username and/or password!");
            $('#password').val("");
        }
    }

    var newInfoArr = $('.newInfo');
    $('#settings').on('click', function () {
        $("label").remove(".error");
        $('#updateInfo').val(0);
        newInfoArr.eq(0).val("<?php echo $currentUserId?>");
        newInfoArr.eq(1).val("<?php echo $currentUsername?>");
    });

    $('#btnSaveChange').on('click', function () {
        $('#profileSubmission').validate();
        newInfoArr.eq(0).prop('disabled', false);
        $('#profileSubmission').submit();
    });

    $('#Password, #cPassword').on('keyup', function () {
        if (($('#Password').val() == $('#cPassword').val()) && $('#Password').val()!="") {
            $('#message').html('Matching').css('color', 'green');
        } else
            $('#message').html('Not Matching').css('color', 'red');
    });
</script>




