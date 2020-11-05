<?php
// Set the JSON header
header("Content-type: text/json");


$mysqli = new mysqli('localhost', 'root', 'root', 'board');

// Count version 1 of content types of interest 
$query = ("select contenttype, count(*)
       from CONTENT
       where version='1' and contenttype='page' or contenttype='comment' or contenttype='blogpost' or contenttype='mail' or contenttype='drafts'
       group by CONTENT.contenttype;");

// execute query
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

// create a php array and echo it as json
//$row = mysql_fetch_assoc($result);
//echo json_encode($row);