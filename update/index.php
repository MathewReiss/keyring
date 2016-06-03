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
<body style="margin-left: 10%; margin-right: 10%;">

    <div class="item-container">
      <div class="item-container-header"><font size="+2">Master Key Settings</font></div>
      <div class="item-container-footer"><font size="+1">
        <?php
          echo "STEP 1";
          
          $servername = "$_ENV[DB_SERVERNAME]";
          $username = "$_ENV[DB_USER]";
          $password = "$_ENV[DB_PASSWORD]";
          $tablename = "$_ENV[DB_TABLENAME]";

          $mysqli = new mysqli($servername, $username, $password);

          echo "STEP 2";

          if($mysqli->connect_error){
            //die("Connection failed: " . $conn->connect_error);
            echo "Error retrieving PIN Code... (Err 1)";
          }

          echo "STEP 3";

         

          if(isset($_GET['email']) && isset($_GET['pin'])){
            $email = mysqli_real_escape_string($mysqli, $_GET['email']);
            $pin = mysqli_real_escape_string($mysqli, $_GET['pin']);

            echo $email . ", " . $pin;

                        

            $sql = "SELECT * FROM $tablename AS kr WHERE kr.email LIKE '$email' AND kr.pin LIKE '$pin';";
            
            echo "<br />" . $sql;

          }/*

            $result = $mysqli->query($sql);
            
            if($result->num_rows == 0){
              $message = "Error retrieving PIN Code... (Err 2)";
            }
            else{
              $result = $result->fetch_assoc();
              $pin = $result['pin'];
            }

            $id = $result['id'];
          }
          else if(isset($_GET['email']){
            echo "STEP 4-B";

            $email = mysqli_real_escape_string($mysqli, $_GET['email']);

            $sql = "INSERT INTO $tablename (email) VALUES ('$email');";
            $mysqli->query($sql);

            $id = $mysqli->insert_id;
            $pin = bindec(strrev(str_pad(decbin($id), 16, '0', STR_PAD_LEFT))) + 10000;

            $sql = "UPDATE $tablename SET pin='$pin' WHERE id=$id;";
            $mysqli->query($sql);

            echo '</font></div></div><script>document.location = document.location + "?email=' . $email . '&pin=' . $pin . '";</script>';
          }
          else{
            echo "STEP 4-C";

            echo "Error with email... (Err 3)";
          }

          echo "STEP 5";
          
          $wu = $result['wu'];
          $owm = $result['owm'];
          $forecast = $result['forecast'];

          $ifttt = $result['ifttt'];
          $wolfram = $result['wolfram'];

          $habits = $result['habits'];
          $travel = $result['travel'];

          echo "Your PIN Code is: <strong>$pin</strong></font></div></div>";

          $mysqli->close();*/
        ?>

    <div class="item-container">
      <div class="item-container-header"><font size="+1"><strong>Weather</strong></font></div>
    </div>

    <hr/>

    <div class="item-container">
      <div class="item-container-header">Open Weather Map</div>
      <div class="item-container-content">
        <label class="item">
          To get an API Key for Open Weather Map, sign up at <a href="https://home.openweathermap.org/users/sign_up" target="_blank">openweathermap.org</a>.
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
          To get an API Key for Weather Underground, sign up at <a href="https://www.wunderground.com/weather/api/d/login.html?apiref=6e08cd57a6ecc73d" target="_blank">wunderground.com</a>.
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="wu" name="wu" value="<?php echo $wu?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header">Forecast IO</div>
      <div class="item-container-content">
        <label class="item">
          To get an API Key for Forecast.io, sign up at <a href="https://developer.forecast.io/register" target="_blank">forecast.io</a>.
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="forecast" name="forecast" value="<?php echo $forecast?>">
          </div>
        </label>
      </div>
    </div>

    <hr/>

    <div class="item-container">
      <div class="item-container-header"><font size="+1"><strong>Web Services</strong></font></div>
    </div>

    <hr/>

    <div class="item-container">
      <div class="item-container-header">IFTTT Maker Channel</div>
      <div class="item-container-content">
        <label class="item">
          To get started with IFTTT and the Maker Channel, sign up at <a href="https://ifttt.com/join" target="_blank">ifttt.com</a>.
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
          To get an API Key for Wolfram Alpha, sign up at <a href="https://developer.wolframalpha.com/portal/signup.html" target="_blank">wolframalpha.com</a>.
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="wolfram" name="wolfram" value="<?php echo $wolfram?>">
          </div>
        </label>
      </div>
    </div>

    <hr/>

    <div class="item-container">
      <div class="item-container-header"><font size="+1"><strong>Pebble</strong></font></div>
    </div>

    <hr/>

    <div class="item-container">
      <div class="item-container-header">My Habits</div>
      <div class="item-container-content">
        <label class="item">
          To get an API Key for My Habits, open the Settings page in your Pebble Time app. For more details, visit the <a href="https://my-habits.net/about" target="_blank">My Habits website</a>.
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="habits" name="habits" value="<?php echo $habits?>">
          </div>
        </label>
      </div>
    </div>

    <hr/>
    <br/>

    <div class="item-container">
      <div class="button-container">
        <input type="button" class="item-button" value="SAVE KEYS" id="save-button" onclick="saveKeys()">
      </div>
    </div>
    <br/>

    <div class="item-container">
      <div class="item-container-footer">Master Key is a 3rd Party Service not affiliated with Pebble Technology Corp. All references to Pebble™ are purely for descriptive purposes.</div>
    </div>
    
  <script>
    function saveKeys(){
      var xhr = new XMLHttpRequest();
      var url = "https://www.pmkey.xyz/insert/index.php";
      url += "?email=<?php echo $email?>&pin=<?php echo $pin?>&id=<?php echo $id?>&owm=" + document.getElementById("owm").value + "&wu=" + document.getElementById("wu").value + "&forecast=" + document.getElementById("forecast").value + "&ifttt=" + document.getElementById("ifttt").value + "&wolfram=" + document.getElementById("wolfram").value + "&habits=" + document.getElementById("habits").value;// + "&travel=" + document.getElementById("travel").value;
      xhr.open("GET", url, true);

      document.getElementById("save-button").value = "SAVING...";

      xhr.onreadystatechange = function(){
        
        if(xhr.readyState === 4 && xhr.status === 200){
          document.getElementById("save-button").value = "SAVE KEYS";

          var result = JSON.parse(xhr.responseText);
          
          if(result.success){
            alert("Keys saved!");
          }
          else{
            alert("E\u0332r\u0332r\u0332o\u0332r\u0332\n\nFor some reason, your API keys were not saved. Please contact support if this issue persists");
          }
        }
      };

      xhr.send();
    }
  </script>
</body>
</html>
