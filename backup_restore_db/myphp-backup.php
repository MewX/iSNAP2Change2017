<?php
date_default_timezone_set('Australia/Adelaide');
$currentDate = date('_d_m_Y');
$database = "isnap2changedb";
$password = "";
$username = "root";
$file = $database. $currentDate. ".sql";
//the path here should be the full path for mysqldump
$cmd = "/usr/local/bin/mysqldump -h localhost --user $username $database > $file";
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