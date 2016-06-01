<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
  
  <title>Master Key</title>
  <link rel="stylesheet" href="/dist/css/slate.min.css">
  <link rel="icon" type="image/png" href="/favicon2.png">
  <script type="text/javascript" src="/dist/js/slate.min.js"></script>
</head>
<body>
  <form id="main-form" action="insert.php" method="get">

    <div class="item-container">
      <div class="item-container-header"><font size="+2">Master Key Settings</font></div>
      <div class="item-container-footer"><font size="+1">
  
        <?php
          $servername = "$_ENV[DB_SERVERNAME]";
          $username = "$_ENV[DB_USER]";
          $password = "$_ENV[DB_PASSWORD]";

          $conn = new mysqli($servername, $username, $password);

          if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
            echo "Error retrieving PIN Code... (Err 1)";
          }

          $token = $_GET['token'];

          date_default_timezone_set('UTC');
          $date = date('Y-m-d H:i:s', time());

          $sql = "SELECT * FROM heroku_f8bdd97336b1c2f.keyring AS kr WHERE kr.token LIKE '$token';";
          $result = $conn->query($sql);

          if($result->num_rows == 0){
            $sql = "INSERT INTO heroku_f8bdd97336b1c2f.keyring (token, lastUpdated) VALUES ('$token', '$date');";
            $result = $conn->query($sql);

            if(!$result){
              echo "Error retrieving PIN Code... (Err 2)";
              return;
            }

            $sql = "SELECT * FROM heroku_f8bdd97336b1c2f.keyring AS kr WHERE kr.token LIKE '$token';";
            $result = $conn->query($sql);

            if(!$result){
              echo "Error retrieving PIN Code... (Err 3)";
              return;
            }            
          }

          $result = $result->fetch_assoc();
          $pin = 10000 + $result['id'];

          $ifttt = $result['ifttt'];
          $wu = $result['wu'];
          $forecast = $result['forecast'];
          $wolfram = $result['wolfram'];
          $habits = $result['habits'];

          echo "Your PIN Code is: <strong>$pin</strong>";
        ?>

      </font></div>
    </div>

    <div class="item-container">
      <div class="item-container-header"><font size="+1"><strong>Weather</strong></font></div>
    </div>

    <div class="item-container">
      <div class="item-container-header">Open Weather Map</div>
      <div class="item-container-content">
        <label class="item">
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="owm" name="owm" value="<?php echo $owm?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header">Weather Underground</div>
      <div class="item-container-content">
        <label class="item">
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="wu" name="wu" value="<?php echo $wu?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header">ForecastIO</div>
      <div class="item-container-content">
        <label class="item">
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="forecast" name="forecast" value="<?php echo $forecast?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header"><font size="+1"><strong>Web Services</strong></font></div>
    </div>

    <div class="item-container">
      <div class="item-container-header">IFTTT Maker Channel</div>
      <div class="item-container-content">
        <label class="item">
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="ifttt" name="ifttt" value="<?php echo $ifttt?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header">Wolfram Alpha</div>
      <div class="item-container-content">
        <label class="item">
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="wolfram" name="wolfram" value="<?php echo $wolfram?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header"><font size="+1"><strong>Pebble</strong></font></div>
    </div>

    <div class="item-container">
      <div class="item-container-header">My Habits</div>
      <div class="item-container-content">
        <label class="item">
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="habits" name="habits" value="<?php echo $habits?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header">Travel/Departure</div>
      <div class="item-container-content">
        <label class="item">
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="travel" name="travel" value="<?php echo $travel?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="button-container">
        <input type="button" class="item-button" value="SAVE KEYS" onclick="save()">
      </div>
    </div>

  </form>
</body>
</html>
