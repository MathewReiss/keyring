<?php
	$servername = "us-cdbr-iron-east-04.cleardb.net:3306";
	$username = "b8f6d467c68b56";
	$password = "a3212cc9";

	// Create connection
	$conn = new mysqli($servername, $username, $password);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	    echo json_encode(array(success => false) + array(error => "Could not connect to Pebble Master Key Database."), JSON_PRETTY_PRINT);
	}

	$pin = $_GET['pin'] - 10000;

	$sql = "SELECT * FROM heroku_f8bdd97336b1c2f.keyring as kr WHERE kr.id LIKE '$pin';";
	$result = $conn->query($sql);			

	if($result->num_rows == 1){
		$result = $result->fetch_assoc();
		unset($result['token']);
		unset($result['id']);
		$result = array(pin => $_GET['pin']*1) + array(success => true) + $result;

		$indices = [wu, ifttt, wolfram, forecast, habits];

		$array = [];

		foreach($indices as $key){
			$array += array($key => $result[$key]);
			unset($result[$key]);
		}

		$array = array(keys => $array);

		$result = $result + $array;

		echo json_encode($result, JSON_PRETTY_PRINT);
	}
	else{
		$result = array(pin => $_GET['pin']*1) + array(success => false) + array(error => "Could not locate any keys for that PIN.");
		echo json_encode($result, JSON_PRETTY_PRINT);
	}
	$conn->close();
?>