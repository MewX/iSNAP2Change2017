<?php
require_once ("../mysql-lib.php");
date_default_timezone_set('Australia/Adelaide');
$currentDate = date('_d_m_Y');
$file = $database. $currentDate. ".sql";
//the path here should be the full path for mysqldump
$cmd = "mysqldump -h localhost -u$username -p$password $database > $file";
system($cmd);

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

?>

