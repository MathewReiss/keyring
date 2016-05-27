<?php
	$servername = "$_ENV[DB_SERVERNAME]";
	$username = "$_ENV[DB_USER]";
	$password = "$_ENV[DB_PASSWORD]";

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

		$weather_indices = [owm, wu, forecast];
		$web_indices = [ifttt, wolfram];
		$pebble_indices = [habits, travel];

		$weather = [];
		foreach($weather_indices as $key){
			$weather += array($key => $result[$key]);
			unset($result[$key]);
		}

		$web = [];
		foreach($web_indices as $key){
			$web += array($key => $result[$key]);
			unset($result[$key]);
		}

		$pebble = [];
		foreach($pebble_indices as $key){
			$pebble += array($key => $result[$key]);
			unset($result[$key]);
		}

		$keys = array(weather => $weather, web => $web, pebble => $pebble);

		$array = array(success => true, lastUpdated => '2016-05-27 12:34:00', keys => $keys);

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-type: application/json");
		echo json_encode($result, JSON_PRETTY_PRINT);
	}
	else{
		$result = array(success => false, error => "Could not locate any keys for that PIN.");
		echo json_encode($result, JSON_PRETTY_PRINT);
	}
	$conn->close();
?>


/*
		foreach($weather_indices as $key){}

		$array = [];

		foreach($indices as $key){
			$array += array($key => $result[$key]);
			unset($result[$key]);
		}

		$array = array(keys => $array);

		$result = $result + $array;
*/