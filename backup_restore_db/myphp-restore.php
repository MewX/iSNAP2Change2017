<?php
require_once ("../mysql-lib.php");
$uploadfile = basename($_FILES['userfile']['name']);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
//the path here should be the full path for mysqldump
    $cmd = "mysql -u$username -p$password $database < $uploadfile";
    //$cmd = "/usr/local/bin/mysql --user $username --password= $password $database < $uploadfile";
    system($cmd);
    echo "Your database is restore successfully";
} else {
    echo "Possible file upload attack!\n";
}
?>
<button onclick="history.go(-1);" class="btn btn-success">Back </button>


