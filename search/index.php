<?php
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET");
	header("Content-type: application/json");

	$servername = "$_ENV[DB_SERVERNAME]";
	$username = "$_ENV[DB_USER]";
	$password = "$_ENV[DB_PASSWORD]";
	$tablename = "$_ENV[DB_TABLENAME]";

	// Create connection
	$mysqli = new mysqli($servername, $username, $password);

	// Check connection
	if ($mysqli->connect_error) {
	    die("Connection failed: " . $mysqli->connect_error);
	    echo json_encode(array(success => false) + array(error => "Could not connect to Pebble Master Key Database."), JSON_PRETTY_PRINT);
	}

	if(isset($_GET['email']) && isset($_GET['pin'])){
		$email = mysqli_real_escape_string($mysqli, $_GET['email']);
		$pin = mysqli_real_escape_string($mysqli, $_GET['pin']);
	}
	else{
		$array = array(success => false, error => "You must provide an Email and PIN as a URL parameter (pin).");
		echo json_encode($array, JSON_PRETTY_PRINT);
		exit;
	}

	echo $email . ", " . $pin . "<br />";

	$sql = "SELECT * FROM $tablename as kr WHERE kr.email LIKE '$email' AND kr.pin LIKE '$pin';";
	$result = $conn->query($sql);		

	echo $result;	

	if($result->num_rows == 1){
		$result = $result->fetch_assoc();
		//unset($result['token']);
		//unset($result['id']);
		//$result = array(pin => $_GET['pin']*1) + array(success => true) + $result;

		$weather_indices = [owm, wu, forecast];
		$web_indices = [ifttt, wolfram];
		$pebble_indices = [habits, travel];

		$weather = [];
		foreach($weather_indices as $key){
			$weather += array($key => $result[$key]);
			//unset($result[$key]);
		}

		$web = [];
		foreach($web_indices as $key){
			$web += array($key => $result[$key]);
			//unset($result[$key]);
		}

		$pebble = [];
		foreach($pebble_indices as $key){
			$pebble += array($key => $result[$key]);
			//unset($result[$key]);
		}

		$keys = array(weather => $weather, web => $web, pebble => $pebble);

		$array = array(success => true, lastUpdated => $result['lastUpdated'], keys => $keys);

		echo json_encode($array, JSON_PRETTY_PRINT);
	}
	else if(!is_numeric($_GET['pin'])){
		$array = array(success => false, error => "PINs must be numeric-only.");		
		echo json_encode($array, JSON_PRETTY_PRINT);
	}
	else if($result->num_rows == 0){
		$array = array(success => false, error => "Could not locate any keys for that PIN.");
		echo json_encode($array, JSON_PRETTY_PRINT);
	}
	else{
		$array = array(success => false, error => "Unknown error. Please contact support.");
		echo json_encode($array, JSON_PRETTY_PRINT);
	}
	$conn->close();
?>