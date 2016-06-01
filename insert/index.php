<?php
    // respond to preflights
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // return only the headers and not the content
    // only allow CORS if we're doing a POST - i.e. no saving for now.
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST') {
        header('Access-Control-Allow-Origin: https://pmkey.xyz');
        header('Access-Control-Allow-Headers: Content-Type');
    }
    exit;
    }

	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Origin: https://pmkey.xyz");
	header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json");

	$servername = "$_ENV[DB_SERVERNAME]";
    $username = "$_ENV[DB_USER]";
    $password = "$_ENV[DB_PASSWORD]";
    $tablename = "$_ENV[DB_TABLENAME]";

    $mysqli = new mysqli($servername, $username, $password);

    if($mysqli->connect_error){
    	//die("Connection failed: " . $conn->connect_error);
		echo json_encode(array(success => false, error => "Connection error"));
		exit;
    }

    $pin = $_POST['pin'];
    $id = $_POST['id'];
    $date = $_POST['date'];

    $owm = $_POST['owm'];
    $wu = $_POST['wu'];
    $forecast = $_POST['forecast'];

    $ifttt = $_POST['ifttt'];
    $wolfram = $_POST['wolfram'];

    $habits = $_POST['habits'];
    $travel = $_POST['wolfram'];

    //New PIN
    if(!is_null($id)){
        //$sql = "UPDATE TABLE '$tablename' SET pin='$pin' WHERE id=$id;";
    	$sql = "UPDATE TABLE '$tablename' SET pin='$pin', lastUpdated='$date', owm='$owm', wu='$wu', forecast='$forecast', ifttt='$ifttt', wolfram='$wolfram', habits='$habits', travel='$travel' WHERE id=$id;";
    }
    //Existing PIN
    else{
    	$sql = "UPDATE TABLE '$tablename' SET 
    				lastUpdated='$date',
    				owm='$owm', 
    				wu='$wu', 
    				forecast='$forecast', 
    				ifttt='$ifttt',
    				wolfram='$wolfram',
    				habits='$habits',
    				travel='$travel' 
    			WHERE pin=$pin;";
    }

    $result = $mysqli->query($sql);

    if($mysqli->affected_rows == 1){
        echo json_encode(array(success => true));    
    }
    else{
        echo json_encode(array(success => false, error => "No rows affected"));
    }	  
?>