<?php

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: *");
	header("Content-type: application/json");
	echo json_encode(array(success => true));

	/*
    $servername = "$_ENV[DB_SERVERNAME]";
	$username = "$_ENV[DB_USER]";
	$password = "$_ENV[DB_PASSWORD]";

	// Create connection
	$conn = new mysqli($servername, $username, $password);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	    
    }
    else{
      	//Get variables via POST
	}
	*/
?>