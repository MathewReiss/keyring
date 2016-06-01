<?php
	$servername = "$_ENV[DB_SERVERNAME]";
    $username = "$_ENV[DB_USER]";
    $password = "$_ENV[DB_PASSWORD]";
    $tablename = "$_ENV[DB_TABLENAME]";

    $mysqli = new mysqli($servername, $username, $password);

    if(true || $mysqli->connect_error){
    	die("Connection failed: " . $conn->connect_error);
    	header("Access-Control-Allow-Headers: Content-Type");
		header("Access-Control-Allow-Origin: https://pmkey.xyz");
		header("Access-Control-Allow-Methods: POST");
		header("Content-Type: application/json");
		echo json_encode(array(success => false));
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
    if(!is_null($_id)){
    	$sql = "UPDATE $tablename SET 
    				pin='$pin', 
    				lastUpdated='$date'
    				owm='$owm', 
    				wu='$wu', 
    				forecast='$forecast', 
    				ifttt='$ifttt',
    				wolfram='$wolfram',
    				habits='$habits',
    				travel='$travel' 
    			WHERE id=$id;";

    }
    //Existing PIN
    else{
    	$sql = "UPDATE $tablename SET 
    				lastUpdated='$date'
    				owm='$owm', 
    				wu='$wu', 
    				forecast='$forecast', 
    				ifttt='$ifttt',
    				wolfram='$wolfram',
    				habits='$habits',
    				travel='$travel' 
    			WHERE pin=$pin;";
    }

    $result = $mysql->query($sql);

	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Origin: https://pmkey.xyz");
	header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json");
	echo json_encode(array(success => true));    
?>