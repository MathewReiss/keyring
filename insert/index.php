<?php

	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Origin: https://pmkey.xyz https://www.pmkey.xyz");
	header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json");
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