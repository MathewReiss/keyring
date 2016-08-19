<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
  
  <title>Master Key</title>
  <link rel="stylesheet" href="../dist/css/slate.min.css">
  <link rel="icon" type="image/png" href="/favicon2.png">
  <script type="text/javascript" src="../dist/js/slate.min.js"></script>
</head>
<body style="margin-left: 10%; margin-right: 10%;">

    <div class="item-container">
      <div class="item-container-header"><font size="+2">Master Key Settings</font></div>
      <div class="item-container-footer"><font size="+1">
        <?php
          $servername = "$_ENV[DB_SERVERNAME]";
          $username = "$_ENV[DB_USER]";
          $password = "$_ENV[DB_PASSWORD]";
          $tablename = "$_ENV[DB_TABLENAME]";

          $mysqli = new mysqli($servername, $username, $password);

          if($mysqli->connect_error){
            //die("Connection failed: " . $conn->connect_error);
            die("Error: Connection Error. Please try again later. (Err 1)");
          }

          if(isset($_GET['email']) && isset($_GET['pin'])){
            $email = mysqli_real_escape_string($mysqli, $_GET['email']);
            $pin = mysqli_real_escape_string($mysqli, $_GET['pin']);

            $sql = "SELECT * FROM $tablename AS kr WHERE kr.email LIKE '$email' AND kr.pin LIKE '$pin';";
            
            $result = $mysqli->query($sql);
            
            if($result->num_rows == 0){
              die("Error: Invalid Email/PIN combination. (Err 2)");
            }
            else{
              $result = $result->fetch_assoc();
              $pin = $result['pin'];
            }
          }
          else if(isset($_GET['email'])){
            $email = mysqli_real_escape_string($mysqli, $_GET['email']);

            $sql = "SELECT * FROM $tablename AS kr WHERE kr.email LIKE '$email';";
            $result = $mysqli->query($sql);

            if($result->num_rows == 0){
              $sql = "INSERT INTO $tablename (email) VALUES ('$email');";
              $mysqli->query($sql);

              $id = $mysqli->insert_id;
              $pin = rand(10000,99999);//bindec(strrev(str_pad(decbin($id), 16, '0', STR_PAD_LEFT))) + 10000;

              $sql = "UPDATE $tablename SET pin='$pin' WHERE id=$id;";
              $mysqli->query($sql);

              echo '</font></div></div><script>document.location = document.location + "&pin=' . $pin . '"; localStorage.setItem("savedPin", "' . $pin . '"); </script>';  
            }
            else{
              die("Error: Email is already registered with Master Key. Please <a href='mailto:mydogsnowy.pebble@gmail.com?subject=Master Key Support' target='_blank'>contact Support</a>. (Err 3)");
            }
          }
          else{
            die("Error: Must provide email to sign up for Master Key. (Err 4)");
          }
          
          $wu = $result['wu'];
          $owm = $result['owm'];
          $forecast = $result['forecast'];

          $ifttt = $result['ifttt'];
          $wolfram = $result['wolfram'];

          $habits = $result['habits'];
          $travel = $result['travel'];

          $home_addr = $result['home_addr'];
          $home_lat = $result['home_lat'];
          $home_lon = $result['home_lon'];

          echo "Your PIN Code is: <strong>$pin</strong></font></div></div>";

          $mysqli->close();
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
          To get an API Key for My Habits, open the Habits Settings page in your Pebble Time app (My Habits users only). For more details, visit the <a href="https://my-habits.net/about" target="_blank">My Habits website</a>.
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="habits" name="habits" value="<?php echo $habits?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header">Travel Priority Access</div>
      <div class="item-container-content">
        <label class="item">
          To get your Travel ID for Priority Access, open the Travel Settings page in your Pebble Time app (First-Class users only).
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="travel" name="travel" value="<?php echo $travel?>">
          </div>
        </label>
      </div>
    </div>

    <div class="item-container">
      <div class="item-container-header">Home Address</div>
      <div class="item-container-content">
        <label class="item">
          Set a home address by name, or by GPS coordinates, for Pebble apps and watchfaces to use as a default location. 
          <div class="item-input-wrapper">
          <font size="-1">&nbsp;Address</font>
            <input type="text" class="item-input" id="home_addr" name="home_addr" value="<?php echo $home_addr?>">
          </div>
          <div class="item-input-wrapper">
          <font size="-1">&nbsp;Latitude</font>
            <input type="text" class="item-input" id="home_lat" name="home_lat" value="<?php echo $home_lat?>">
          </div>
          <div class="item-input-wrapper">
          <font size="-1">&nbsp;Longitude</font>
            <input type="text" class="item-input" id="home_lon" name="home_lon" value="<?php echo $home_lon?>">
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
      url += "?email=<?php echo $email?>&pin=<?php echo $pin?>&owm=" + document.getElementById("owm").value + "&wu=" + document.getElementById("wu").value + "&forecast=" + document.getElementById("forecast").value + "&ifttt=" + document.getElementById("ifttt").value + "&wolfram=" + document.getElementById("wolfram").value + "&habits=" + document.getElementById("habits").value + "&travel=" + document.getElementById("travel").value + "&home_addr=" + document.getElementById("home_addr").value + "&home_lat=" + document.getElementById("home_lat").value + "&home_lon=" + document.getElementById("home_lon").value;
      xhr.open("GET", url, true);

      document.getElementById("save-button").value = "SAVING...";

      xhr.onreadystatechange = function(){
        
        if(xhr.readyState === 4 && xhr.status === 200){
          document.getElementById("save-button").value = "SAVE KEYS";

          var result = JSON.parse(xhr.responseText);
          
          if(result.success){
            if(result.numRows !== 0) alert("Keys saved!");
            else alert("No changes to keys detected.");
          }
          else{
            alert("E\u0332r\u0332r\u0332o\u0332r\u0332\n\nFor some reason, your API keys were not saved. Please contact support if this issue persists");
            console.log(JSON.stringify(result));
          }
        }
      };

      xhr.send();
    }
  </script>
</body>
</html>
