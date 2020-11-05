<?php // Initialize variable for database credentials 
$dbhost = 'localhost'; 
$dbuser = 'root'; 
$dbpass = 'root'; 
$dbname = 'board'; 
//Create database connection 
$dblink = new mysqli($dbhost, $dbuser, $dbpass, $dbname); 
//Check connection was successful 
if ($dblink->connect_errno) {
     printf("Failed to connect to database");
      exit(); }
       //Fetch 3 rows from actor table 
       $result = $dblink->query("select * from data limit 3");
       //Initialize array variable 
       $dbdata = array(); 
       //Fetch into associative array 
       while ( $row = $result->fetch_assoc()) { $dbdata[]=$row; } 
        echo json_encode($dbdata); ?>

