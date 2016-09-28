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
		    
		  //BEGIN EMAIL CODE 
		    
	      define('POSTMARK_API_KEY', "$_ENV[POSTMARK_API_KEY]");
function send_email($sendemail, &$response = null, &$http_code = null) {
    $json = json_encode(array(
        'From' => $sendemail['from'],
        'To' => $sendemail['to'],
        'Cc' => $sendemail['cc'],
        'Bcc' => $sendemail['bcc'],
        'Subject' => $sendemail['subject'],
        'Tag' => $sendemail['tag'],
        'HtmlBody' => $sendemail['html_body'],
        'TextBody' => $sendemail['text_body'],
        'ReplyTo' => $sendemail['reply_to'],
        'Headers' => $sendemail['headers'],
        'Attachments' => $sendemail['attachments']
    ));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json',
        'X-Postmark-Server-Token: ' . POSTMARK_API_KEY
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $response = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $http_code === 200;
}

send_email(array(
    'to' => $_GET['email'],
    'from' => 'Master Key <donotreply@pmkey.xyz>',
    'subject' => 'Your Master Key PIN',
    'text_body' => 'Your email is ' . $email . ' and your PIN is ' . $pin . '.',
    'html_body' => //'<html><body>Your email is <em>' . $email . '</em> and your PIN is <strong>' . $pin . '</strong>.<br /><br />Be sure to check out all of the awesome <a href="https://apps.getpebble.com/en_US/collection/master-key/watchfaces/1" target="_blank">Master Key-enabled watchfaces in the Pebble Appstore</a>.</body></html>'
'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="format-detection" content="telephone=no"> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <title>Page title</title>
    <style type="text/css"> 
    	@import url(http://fonts.googleapis.com/css?family=Roboto:300); /*Calling our web font*/
	
        /* Some resets and issue fixes */
        #outlook a { padding:0; }
        body{ width:100% !important; -webkit-text; size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; }     
        .ReadMsgBody { width: 100%; }
        .ExternalClass {width:100%;} 
        .backgroundTable {margin:0 auto; padding:0; width:100%;!important;} 
        table td {border-collapse: collapse;}
        .ExternalClass * {line-height: 115%;}           
        /* End reset */
        /* These are our tablet/medium screen media queries */
        @media screen and (max-width: 630px){
            /* Display block allows us to stack elements */                      
            *[class="mobile-column"] {display: block;} 
            /* Some more stacking elements */
            *[class="mob-column"] {float: none !important;width: 100% !important;}     
            /* Hide stuff */
            *[class="hide"] {display:none !important;}          
            /* This sets elements to 100% width and fixes the height issues too, a god send */
            *[class="100p"] {width:100% !important; height:auto !important;}                    
            /* For the 2x2 stack */         
            *[class="condensed"] {padding-bottom:40px !important; display: block;}
            /* Centers content on mobile */
            *[class="center"] {text-align:center !important; width:100% !important; height:auto !important;}            
            /* 100percent width section with 20px padding */
            *[class="100pad"] {width:100% !important; padding:20px;} 
            /* 100percent width section with 20px padding left & right */
            *[class="100padleftright"] {width:100% !important; padding:0 20px 0 20px;} 
            /* 100percent width section with 20px padding top & bottom */
            *[class="100padtopbottom"] {width:100% !important; padding:20px 0px 20px 0px;} 
        }
    </style>
</head>
<body style="padding:0; margin:0" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">
<table width="640" cellspacing="0" cellpadding="0" bgcolor="#" class="100p">
                <tr>
                    <td bgcolor="#3b464e" width="640" valign="top" class="100p">
                        <!--[if gte mso 9]>
                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;">
                            <v:fill type="tile" src="images/header-bg.jpg" color="#3b464e" />
                            <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
                                <![endif]-->
                                <div>
                                    <table width="640" border="0" cellspacing="0" cellpadding="20" class="100p">
                                        <tr>
                                            <td valign="top">                                               
                                                <table border="0" cellspacing="0" cellpadding="0" width="600" class="100p">   
						      <tr>		
 -                                                        <td height="10"></td>		
 -                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="color:#FFFFFF; font-size:24px;">
								
                                                            <font face="\'Roboto\', Arial, sans-serif">
                                                                <span style="font-size:44px;">Thanks for signing up!</span><br />
                                                                <br />
                                                                <Span style="font-size:24px;">With Master Key, you\'ve just unlocked a world of possiblities.</Span>
                                                                <br /><br />
																
																<Span style="font-size:24px;"><em>Your Email is <strong>' . $email . '</strong>.</em></Span>
                                                                <br /><br />
																<Span style="font-size:24px;"><em>Your PIN is <strong>' . $pin . '</strong>.</em></Span>
                                                                <br />
                                                                <hr />
                                                                <Span style="font-size:24px;">See what watchfaces support Master Key!</Span>
                                                                <br /><br />
                                                                <table border="0" cellspacing="0" cellpadding="10" style="border:2px solid #FFFFFF;">
                                                                    <tr>
                                                                        <td align="center" style="color:#FFFFFF; font-size:16px;"><font face="\'Roboto\', Arial, sans-serif"><a href="https://apps.getpebble.com/en_US/collection/master-key/watchfaces/1" style="color:#FFFFFF; text-decoration:none;">View Enabled Watchfaces</a></font></td>
                                                                    </tr>
                                                                </table>
								
								
								 <td align="center" style="color:#AAAAAA; font-size:8px;"><font face="\'Roboto\', Arial, sans-serif"><br /><br />For more information, visit <a href="https://pmkey.xyz"  target="_blank" style="text-decoration: none">pmkey.xyz</a>.</font></td>
					
                                                            </font>		    
             	                                        </td>
                                                    </tr>
						    <tr>		
 -                                                        <td align="center" style="color:#AAAAAA; font-size:8px;"><font face="\'Roboto\', Arial, sans-serif"><br /><br />For more information, visit <a href="https://pmkey.xyz"  target="_blank" style="text-decoration: none">pmkey.xyz</a>.</font></td>		
 -                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!--[if gte mso 9]>
                            </v:textbox>
                        </v:rect>
                        <![endif]-->
                    </td>
                </tr>
            </table>
</body>
</html>
'
), $response, $http_code);
		    
		    //END EMAIL CODE
              
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
          $stepverse = $result['stepverse'];
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
      <div class="item-container-header">StepVerse Sync</div>
      <div class="item-container-content">
        <label class="item">
          To get an API Key for StepVerse, open the StepVerse Settings page in your Pebble Time app. For more details, visit the <a href="https://stepverse.com" target="_blank">StepVerse website</a>.
          <div class="item-input-wrapper">
            <input type="text" class="item-input" id="stepverse" name="stepverse" value="<?php echo $stepverse?>">
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
      url += "?email=<?php echo $email?>&pin=<?php echo $pin?>&owm=" + document.getElementById("owm").value + "&wu=" + document.getElementById("wu").value + "&forecast=" + document.getElementById("forecast").value + "&ifttt=" + document.getElementById("ifttt").value + "&wolfram=" + document.getElementById("wolfram").value + "&habits=" + document.getElementById("habits").value + "&stepverse=" + document.getElementById("stepverse").value + "&travel=" + document.getElementById("travel").value + "&home_addr=" + document.getElementById("home_addr").value + "&home_lat=" + document.getElementById("home_lat").value + "&home_lon=" + document.getElementById("home_lon").value;
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
