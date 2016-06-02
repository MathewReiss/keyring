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
    <div class="item-container-header">Pebble Master Key</div>
    <div class="item-container-content">
      <label class="item">
        Pebble Master Key is a new service for Pebble users. Get a unique PIN and add API Keys for your favorite online services.<br /><br />Then, enter your PIN on the Settings page of any <a href="https://apps.getpebble.com/en_US/search/watchapps/1?native=false&query=pmkey.xyz" target="_blank">Master Key-enabled watchface or app</a>, and that's it!<br /><br /><em>No more annoying copy/paste from your phone browser.<br /><br />No more long alphanumeric codes to type on a tiny keyboard.</em><br /><br />Encourage the developers of your favorite Pebble faces and apps to start using Master Key, today!
      </label>
      <label class="item">
        <div class="item-input-wrapper item-input-wrapper-button">
          <input type="number" class="item-input" id="pin" name="pin" placeholder="5-digit PIN">
        </div>
        <input type="button" class="item-button item-input-button" id="pin-button" name="pin-button" value="SIGN IN" onclick="login()">
      </label>
      <label class="item">
        <center>Don't have a PIN? <a href="/update">Click here</a> to sign up for one.</center>
      </label>
      <label class="item">
        <center>Forgot your PIN? Other issues? <a href="mailto:mydogsnowy.pebble@gmail.com?subject=Master Key Support" target="_blank">Contact Support</a>.</center>
      </label>
    </div>
    <div class="item-container-footer">Are you a Developer interested in integrating Master Key into your Pebble watchface or app? <a href="/developer">Click here</a> for Master Key Documentation and Example Implementations.</div>
    <br />
    <div class="item-container-footer">Master Key is a 3rd Party Service not affiliated with Pebble Technology Corp. All references to Pebble™ are purely for descriptive purposes.</div>
    <div class="item-container-footer">Master Key is provided as-is and is not liable for any use or misuse of API Keys stored through the service.</div>
  </div>

  <div class="item-container">
    <div class="item-container-footer">
      <label class="item">
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.pmkey.xyz" data-text="Check out #MasterKey for @Pebble! Makes life so much easier." data-size="large">Tweet #MasterKey</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
      </label>
    </div>
  </div>

  <script>
    var savedPin = localStorage.getItem("savedPin");
    if(savedPin !== null){
      document.getElementById("pin").value = parseInt(savedPin);
    }

    function login(){
      var pin = document.getElementById("pin").value;

      if(pin === null || isNaN(pin) || pin < 10000 || pin > 99999){
        alert("I\u0332n\u0332v\u0332a\u0332l\u0332i\u0332d\u0332 P\u0332I\u0332N\u0332\n\nPlease enter your 5-digit PIN. If you do not remember it, you may sign up for a new PIN, or contact support.");
      }
      else{
        localStorage.setItem("savedPin", pin);

        document.location = document.location + "/update?pin=" + pin;
      }
    }
  </script>
</body>
</html>
