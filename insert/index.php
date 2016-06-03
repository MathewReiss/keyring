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

    $email = $mysqli->real_escape_string($_GET['email']);
    $pin = $mysqli->real_escape_string($_GET['pin']);
    $id = $mysqli->real_escape_string($_GET['id']);

    $owm = $mysqli->real_escape_string($_GET['owm']);
    $wu = $mysqli->real_escape_string($_GET['wu']);
    $forecast = $mysqli->real_escape_string($_GET['forecast']);

    $ifttt = $mysqli->real_escape_string($_GET['ifttt']);
    $wolfram = $mysqli->real_escape_string($_GET['wolfram']);

    $habits = $mysqli->real_escape_string($_GET['habits']);
    $travel = $mysqli->real_escape_string($_GET['travel']);

    //New PIN
    if(!is_null($id)){
        $pin = bindec(strrev(str_pad(decbin($id), 16, '0', STR_PAD_LEFT))) + 10000;
    	$sql = "UPDATE $tablename SET pin='$pin', owm='$owm', wu='$wu', forecast='$forecast', ifttt='$ifttt', wolfram='$wolfram', habits='$habits', travel='$travel' WHERE id=$id AND email=$email;";
    }
    //Existing PIN
    else{
    	$sql = "UPDATE $tablename SET owm='$owm', wu='$wu', forecast='$forecast', ifttt='$ifttt', wolfram='$wolfram', habits='$habits', travel='$travel' WHERE pin=$pin AND email=$email;";
    }

    $result = $mysqli->query($sql);

    if($mysqli->affected_rows == 1){
        echo json_encode(array(success => true));    
    }
    else{
        echo json_encode(array(success => false, error => "No rows affected"));
    }	  
?>