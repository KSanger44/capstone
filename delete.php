<?php

//connect to the db schema
$servername = "localhost:3306";
$username = "root";
$password = '';
$dbname = "capstone_database";
//$dbname = "kmkelmo1_capstone_database";
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['deleteproj']))
{
    $sql = "UPDATE PROJECT, CLIENT, PROJECTANDCLIENT
    SET PROJECT.archive = '1'
    WHERE PROJECTANDCLIENT.ProjectID = '$projectID'";
     $mysqli->query($sql);
	 echo 'Deleted successfully.';
}


?>