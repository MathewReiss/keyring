<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
  
  <title>Master Key Settings</title>
  <link rel="stylesheet" href="https://dl.dropboxusercontent.com/s/9vzn6jmlvzogvi1/slate.css">
  <script type="text/javascript" src="https://dl.dropboxusercontent.com/s/zyba8qboh5czip8/slate.js"></script>
</head>
<body>
  <form id="main-form" action="insert.php" method="get">

    <div class="item-container">

    	<?php

    		$servername = "us-cdbr-iron-east-04.cleardb.net:3306";
			$username = "b8f6d467c68b56";
			$password = "a3212cc9";

			// Create connection
			$conn = new mysqli($servername, $username, $password);

			// Check connection
			if ($conn->connect_error) {
	    		die("Connection failed: " . $conn->connect_error);
	    		
	    		echo '<div class="item-container-header"><font size="+2">Error</font></div>';
      			echo '<div class="button-container">';
      			echo '	<input type="button" class="item-button" value="RETURN TO SETTINGS" onclick="return()">';
      			echo '</div>';
      			return;
			}

			$pin = $_GET['pin'] - 10000;
			$ifttt = $_GET['ifttt'];
			$wu = $_GET['wu'];
			$forecast = $_GET['forecast'];
			$wolfram = $_GET['wolfram'];
			$habits = $_GET['habits'];

			date_default_timezone_set('UTC');
    		$date = date('Y-m-d H:i:s', time());

			$sql = "UPDATE heroku_f8bdd97336b1c2f.keyring as kr SET ifttt='$ifttt', wu='$wu', forecast='$forecast', wolfram='$wolfram', habits='$habits', lastUpdated='$date' WHERE kr.id LIKE '$pin';";
			$result = $conn->query($sql);			

			if($result){
      			echo '<div class="item-container-header"><font size="+2">Success!</font></div>';
      			echo '<div class="button-container">';
      			echo '	<input type="button" class="item-button" value="CLOSE" onclick="close()">';
      			echo '</div>';
      		}
      		else{
      			echo '<div class="item-container-header"><font size="+2">Error</font></div>';
      			echo '<div class="button-container">';
      			echo '	<input type="button" class="item-button" value="RETURN TO SETTINGS" onclick="back()">';
      			echo '</div>';
			}
      ?>
  </div>
</form>

<script>
	function close(){
		var options = { 'pin' : <?php echo "$_GET[pin]"; ?> };

    console.log(options.pin);

		document.location = 'pebblejs://close#' + encodeURIComponent(JSON.stringify(options));
	}

	function back(){
		document.location = '/config?token=<?php echo $_GET[token] ?>';
	}
</script>

</body>

</html>