<?php

$connect = new mysqli('localhost', 'root', 'root', 'board');

header( "Content-type: application/vnd.ms-excel; charset=utf-8");

header( "Content-Disposition: attachment; filename = data.xls" );     

header( "Content-Description: PHP4 Generated Data" );

$EXCEL_FILE = "

<table border='1'>

    <tr>

       <td>LOG_SEQ</td>

       <td>METER_SEQ</td>

       <td>DATE</td>

       <td>ENERGY</td>

       <td>WH</td>

       <td>PT</td>

       <td>DEGREE</td>

    </tr>

";

$sdate = $_GET['sdate'] != null ? $_GET['sdate'] : "1970-01-01";
$edate = $_GET['edate'] != null ? $_GET['edate'] : "1970-01-01";

$stime = $_GET['stime'] != null ? $_GET['stime'] : "00:00";
$etime = $_GET['etime'] != null ? $_GET['etime'] : "23:59";

$query = "select * from sdata where STR_TO_DATE('".$sdate." ".$stime.":00','%Y-%m-%d %H:%i:%s') < time and time < STR_TO_DATE('".$edate." ".$etime.":00','%Y-%m-%d %H:%i:%s')";

$result = $connect->query($query);

while ($row = $result->fetch_object()) {

$EXCEL_FILE .= "
    <tr>
       <td>".$row->LOG_SEQ."</td>
       <td>".$row->METER_SEQ."</td>
       <td>".$row->TIME."</td>
       <td>".$row->ENERGY."</td>
       <td>".$row->WH."</td>
       <td>".$row->PT."</td>
       <td>".$row->DEGREE."</td>
    </tr>
";

}

$EXCEL_FILE .= "</table>";

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

echo $EXCEL_FILE;

?>