<?php
    header("Access-Control-Allow-Origin: https://pmkey.xyz");

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

    $pin = $_GET['pin'];
    $id = $_GET['id'];
    $date = $_GET['date'];

    $owm = $_GET['owm'];
    $wu = $_GET['wu'];
    $forecast = $_GET['forecast'];

    $ifttt = $_GET['ifttt'];
    $wolfram = $_GET['wolfram'];

    $habits = $_GET['habits'];
    $travel = $_GET['travel'];

    //New PIN
    if(!is_null($id)){
        $pin = bindec(strrev(str_pad(decbin($id), 16, '0', STR_PAD_LEFT))) + 10000;
    	$sql = "UPDATE $tablename SET pin='$pin', lastUpdated='$date', owm='$owm', wu='$wu', forecast='$forecast', ifttt='$ifttt', wolfram='$wolfram', habits='$habits', travel='$travel' WHERE id=$id;";
    }
    //Existing PIN
    else{
    	$sql = "UPDATE $tablename SET lastUpdated='$date', owm='$owm', wu='$wu', forecast='$forecast', ifttt='$ifttt', wolfram='$wolfram', habits='$habits', travel='$travel' WHERE pin=$pin;";
    }

    $result = $mysqli->query($sql);

    if($mysqli->affected_rows == 1){
        echo json_encode(array(success => true));    
    }
    else{
        echo json_encode(array(success => false, error => "No rows affected"));
    }	  
?>