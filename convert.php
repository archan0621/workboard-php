<?php
$dbhost = 'localhost'; 
$dbuser = 'root'; 
$dbpass = 'root'; 
$dbname = 'board'; 
$dblink = new mysqli($dbhost, $dbuser, $dbpass, $dbname); 

if ($dblink->connect_errno) {
     printf("Failed to connect to database");
      exit(); }
       $result = $dblink->query("select * from data limit 3");
       $dbdata = array(); 
       while ( $row = $result->fetch_assoc()) { $dbdata[]=$row; } 
        echo json_encode($dbdata); ?>

