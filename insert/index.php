<?php
    header("Access-Control-Allow-Origin: https://pmkey.xyz");

	$servername = "$_ENV[DB_SERVERNAME]";
    $username = "$_ENV[DB_USER]";
    $password = "$_ENV[DB_PASSWORD]";
    $tablename = "$_ENV[DB_TABLENAME]";

    $mysqli = new mysqli($servername, $username, $password);

    if($mysqli->connect_error){
		echo json_encode(array(success => false, error => "Connection error"));
		exit;
    }

    $email = mysqli_real_escape_string($mysqli, $_GET['email']);
    $pin = mysqli_real_escape_string($mysqli, $_GET['pin']);
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);

    $owm = mysqli_real_escape_string($mysqli, $_GET['owm']);
    $wu = mysqli_real_escape_string($mysqli, $_GET['wu']);
    $forecast = mysqli_real_escape_string($mysqli, $_GET['forecast']);

    $ifttt = mysqli_real_escape_string($mysqli, $_GET['ifttt']);
    $wolfram = mysqli_real_escape_string($mysqli, $_GET['wolfram']);

    $habits = mysqli_real_escape_string($mysqli, $_GET['habits']);
    $travel = mysqli_real_escape_string($mysqli, $_GET['travel']);

    $home_addr = mysqli_real_escape_string($mysqli, $_GET['home_addr']);
    $home_lat = mysqli_real_escape_string($mysqli, $_GET['home_lat']);
    $home_lon = mysqli_real_escape_string($mysqli, $_GET['home_lon']);

    $sql = "UPDATE $tablename SET owm='$owm', wu='$wu', forecast='$forecast', ifttt='$ifttt', wolfram='$wolfram', habits='$habits', travel='$travel', home_addr='$home_addr', home_lat='$home_lat', home_lon='$home_lon' WHERE email LIKE '$email' AND pin LIKE '$pin';";
    $result = $mysqli->query($sql);

    if($mysqli->affected_rows == 1){
        echo json_encode(array(success => true, numRows => 1));    
    }
    else{
        echo json_encode(array(success => true, numRows => 0));
    }	
    $mysqli->close();  
?>