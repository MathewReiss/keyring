<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
  
  <title>Pebble Master Key</title>
  <link rel="stylesheet" href="/dist/css/slate.min.css">
  <link rel="icon" type="image/png" href="/favicon2.png">
  <script type="text/javascript" src="/dist/js/slate.min.js"></script>
</head>
<body>
  <!--<form id="main-form" action="insert.php" method="post">-->

    <div class="item-container">
      <div class="item-container-header"><font size="+2">Master Key Settings</font></div>
      <div class="item-container-footer"><font size="+1">
  
        <?php
          $servername = "$_ENV[DB_SERVERNAME]";
          $username = "$_ENV[DB_USER]";
          $password = "$_ENV[DB_PASSWORD]";

          $mysqli = new mysqli($servername, $username, $password);

          if($mysqli->connect_error){
            die("Connection failed: " . $conn->connect_error);
            echo "Error retrieving PIN Code... (Err 1)";
          }

          if(isset($_GET['pin'])){
            $pin = $_GET['pin'];

            date_default_timezone_set('UTC');
            $date = date('Y-m-d H:i:s', time());

            $sql = "SELECT * FROM heroku_f8bdd97336b1c2f.keyring AS kr WHERE kr.pin LIKE '$pin';";
            $result = $mysqli->query($sql);
            
            if($result->num_rows == 0){
              echo "Error retrieving PIN Code... (Err 2)";
            }
            else{
              $result = $result->fetch_assoc();
              $pin = $result['pin'];
            }
          }
          else{
            $sql = "INSERT INTO heroku_f8bdd97336b1c2f.keyring (lastUpdated) VALUES ('$date');";
            $result = $mysqli->query($sql);

            $pin = bindec(strrev(str_pad(decbin($mysqli->insert_id), 16, '0', STR_PAD_LEFT))) + 10000;
          }
          
          $wu = $result['wu'];
          $owm = $result['owm'];
          $forecast = $result['forecast'];

          $ifttt = $result['ifttt'];
          $wolfram = $result['wolfram'];

          $habits = $result['habits'];
          $travel = $travel['travel'];

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
        <input type="button" class="item-button" value="SAVE KEYS" id="save-button" onclick="save()">
      </div>
    </div>

  <!--</form>-->

  <script>
    function save(){
      var xhr = new XMLHttpRequest();
      var url = document.location.split("?")[0] + "/insert/index.php";
      xhr.open("POST", url, false);
      xhr.setRequestHeader("Content-type", "application/json");

      var keys = {
        'pin' : <?php echo $pin?>,
        'date' : <?php echo $date?>,
        'owm' : document.getElementById("owm").value,
        'wu' : document.getElementById("wu").value,
        'forecast' : document.getElementById("forecast").value,
        'ifttt' : document.getElementById("ifttt").value,
        'wolfram' : document.getElementById("wolfram").value,
        'habits' : document.getElementById("habits").value,
        'travel' : document.getElementById("travel").value
      };

      document.getElementById("save-button").value = "SAVING...";

      xhr.send(encodeURIComponent(JSON.stringify(keys)));

      document.getElementById("save-button").value = "SAVE KEYS";

      var result = JSON.parse(xhr.responseText);

      if(result.success){
        alert("Keys saved!");
      }
      else{
        alert("E\u0332r\u0332r\u0332o\u0332r\u0332\n\nFor some reason, your API keys were not saved. Please contact support if this issue persists");
      }
    }
  </script>
</body>
</html>
