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
      <div class="item-container-header"><font size="+2">Master Key Settings</font></div>
      <div class="item-container-footer"><font size="+1">
  
        <?php
          $servername = "us-cdbr-iron-east-04.cleardb.net:3306";
          $username = "b8f6d467c68b56";
          $password = "a3212cc9";

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
      <div class="button-container">
        <input type="button" class="item-button" value="SAVE KEYS" onclick="save()">
      </div>
    </div>

  </form>

  <script>
    function getQueryParams(variable, default_){
      var query = location.search.substring(1);
      var vars = query.split('&');

      for(var i = 0; i < vars.length; i++){
        var pair = vars[i].split('=');

        if(pair[0] == variable) return decodeURIComponent(pair[1]);
      }
      return default_ || false;
    }

    function save(){
      var options = {
        'ifttt' : document.getElementById("ifttt").value,
        'wu' : document.getElementById("wu").value,
        'forecast' : document.getElementById("forecast").value,
        'wolfram' : document.getElementById("wolfram").value,
        'habits' : document.getElementById("habits").value
      };

      var return_to = '/insert.php?pin=' + <?php echo $pin ?> + '&token=<?php echo $_GET[token]?>&ifttt=' + options.ifttt + '&wu=' + options.wu + '&forecast=' + options.forecast + '&wolfram=' + options.wolfram + '&habits=' + options.habits;//getQueryParams('return_to', 'pebblejs://close#');
      
      document.location = return_to;
    }
  </script>
</body>
</html>
