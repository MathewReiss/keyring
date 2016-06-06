<?php
	session_id(isset($_GET['email']) ? str_replace("@", "", str_replace(".", "", $_GET['email'])) : session_id());
	session_start();
    if(isset($_SESSION['LAST_CALL'])) {
        $last = strtotime($_SESSION['LAST_CALL']);
        $curr = strtotime(date("Y-m-d h:i:s"));
        $sec = abs($last - $curr);
        if($sec <= 1){
        	header("Access-Control-Allow-Headers: Content-Type");
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Methods: GET");
        	header("Content-Type: application/json");
            echo json_encode(array(success => false, error => "Rate limit exceeded"));
            exit;
        }
    }
    $_SESSION['LAST_CALL'] = date("Y-m-d h:i:s");

	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET");
	header("Content-Type: application/json");

	$servername = "$_ENV[DB_SERVERNAME]";
	$username = "$_ENV[DB_USER]";
	$password = "$_ENV[DB_PASSWORD]";
	$tablename = "$_ENV[DB_TABLENAME]";

	// Create connection
	$mysqli = new mysqli($servername, $username, $password);

	// Check connection
	if ($mysqli->connect_error) {
	    echo json_encode(array(success => false) + array(error => "Could not connect to Pebble Master Key Database."), JSON_PRETTY_PRINT);
	    exit;
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

	$sql = "SELECT * FROM $tablename as kr WHERE kr.email LIKE '$email' AND kr.pin LIKE '$pin';";
	$result = $mysqli->query($sql);		

	if($result->num_rows == 1){
		$result = $result->fetch_assoc();

		$weather_indices = [owm, wu, forecast];
		$web_indices = [ifttt, wolfram];
		$pebble_indices = [habits, travel];

		$weather = [];
		foreach($weather_indices as $key){
			$weather += array($key => $result[$key]);
		}

		$web = [];
		foreach($web_indices as $key){
			$web += array($key => $result[$key]);
		}

		$pebble = [];
		foreach($pebble_indices as $key){
			$pebble += array($key => $result[$key]);
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
		$array = array(success => false, error => "Could not locate any keys for that Email/PIN combination.");
		echo json_encode($array, JSON_PRETTY_PRINT);
	}
	else{
		$array = array(success => false, error => "Unknown error. Please contact support.");
		echo json_encode($array, JSON_PRETTY_PRINT);
	}
	$mysqli->close();
?>