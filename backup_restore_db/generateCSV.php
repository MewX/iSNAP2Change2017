<?php
require_once ("../mysql-lib.php");
$conn = db_connect();
$sql = "SELECT * FROM Student;";
$Query = $conn->prepare($sql);
$Query->execute();
$result = $Query->fetchAll();
$header = "";
$data = "";
$total_column = $Query->columnCount();

for ($counter = 0; $counter < $total_column; $counter ++) {
    $meta = $Query->getColumnMeta($counter);
    $header .= '"' . $meta['name'] . '",';
}
$header .= "\n";
for($i = 0; $i < count($result); $i++){
    for($j = 0; $j<count($result[$i])/2; $j++){
            $data .= '"' . $result[$i][$j] . '",';
    }
    $data .= "\t\n";
}
$filename = "myFile.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
$output = $header . $data;
echo $output;
exit;
?>
//
//$select = "SELECT * FROM table_name";
//
//$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );
//
//$fields = mysql_num_fields ( $export );
//
//for ( $i = 0; $i < $fields; $i++ )
//{
//    $header .= mysql_field_name( $export , $i ) . "\t";
//}
//
//while( $row = mysql_fetch_row( $export ) )
//{
//    $line = '';
//    foreach( $row as $value )
//    {
//        if ( ( !isset( $value ) ) || ( $value == "" ) )
//        {
//            $value = "\t";
//        }
//        else
//        {
//            $value = str_replace( '"' , '""' , $value );
//            $value = '"' . $value . '"' . "\t";
//        }
//        $line .= $value;
//    }
//    $data .= trim( $line ) . "\n";
//}
//$data = str_replace( "\r" , "" , $data );
//
//if ( $data == "" )
//{
//    $data = "\n(0) Records Found!\n";
//}
//
//header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=your_desired_name.xls");
//header("Pragma: no-cache");
//header("Expires: 0");
//print "$header\n$data";

?>