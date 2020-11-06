<?php

$mysqli = new mysqli('localhost', 'root', 'root', 'board');

header( "Content-type: application/vnd.ms-excel; charset=utf-8");

header( "Content-Disposition: attachment; filename = data.xls" );     

header( "Content-Description: PHP4 Generated Data" );

$EXCEL_FILE = "

<table border='1'>

    <tr>

       <td>number</td>

       <td>time</td>

       <td>value</td>

       <td>degree</td>

       <td>conver</td>

    </tr>

";

$qry = "select * from data LIMIT 100000";

$res = $mysqli->query($qry);

while ($row = $res->fetch_object()) {

$EXCEL_FILE .= "
    <tr>
       <td>".$row->number."</td>
       <td>".$row->time."</td>
       <td>".$row->value."</td>
       <td>".$row->degree."</td>
       <td>".$row->conver."</td>
    </tr>
";

}

$EXCEL_FILE .= "</table>";

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

echo $EXCEL_FILE;

?>