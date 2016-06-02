<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
  
  <title>Pebble Master Key</title>
  <link rel="stylesheet" href="https://dl.dropboxusercontent.com/s/9vzn6jmlvzogvi1/slate.css">
  <link rel="icon" type="image/png" href="/favicon2.png">
  <script type="text/javascript" src="https://dl.dropboxusercontent.com/s/zyba8qboh5czip8/slate.js"></script>
</head>
<body style="margin-left: 10%; margin-right: 10%;">
  <div class="item-container">
      <div class="item-container-header">Pebble Master Key</div>
      <div class="item-container-content">
        <label class="item">
            Master Key makes it easier than ever to ask your users to provide their own API keys for services with strict rate-limits. Rather than asking for a long Weather Underground API Key, for example, all you need from your user is their 5-digit Master Key PIN.
        </label>
        <label class="item">
          <strong><font size="+2">Requirements</font></strong><br />
          The only requirements for integrating Master Key into your app are to:<br />
          • Include "pmkey.xyz" in your Appstore Description so that your watchface or app shows up when users search for <a href="https://apps.getpebble.com/en_US/search/watchapps/1?native=false&query=pmkey.xyz" target="_blank">Master Key-enabled watchfaces or apps</a>.<br />
          • Not abuse the API by attempting to scrape or pull keys in any way not for the sole purpose of benefitting the end user in the manner described above. This API is a free service that I provide for fun, and will be shut down if it is abused.
        </label>
        <label class="item">
            <strong><font size="+2">API Endpoint</font></strong><br />
            To get the relevant API keys, simply call the following URL via HTTP GET, passing the user's PIN as a parameter: <pre>https://pmkey.xyz/search?pin=10000</pre><br />
            The JSON response will look like the following:<br />
            <pre>
  {
    success : true,
    lastUpdated : "2016-06-02 14:25:42",
    keys : {
      weather : {
        owm : "owmapikey",
        wu : "wuapikey",
        forecast : "forecastapikey"
      },
      web : {
        ifttt : "makerapikey",
        wolfram : "wolframapikey"
      },
      pebble : {
        habits : "myhabitsapikey"
      }
    }
  }
            </pre>
            <em>Keep in mind that any one of these keys could be returned as an empty string</em>.<br /><br />
            If there is an error with your request, the JSON response will look like the following:<br />
            <pre>
  {
    success : false,
    error : "Could not locate any keys for that PIN."
  }
            </pre>
          </label>
          <label class="item">
            <strong><font size="+2">Simple Settings Page Example</font></strong><br />
            Below is the Javascript code for a simple implementation of Master Key, using the "webviewclosed" event handler in PebbleKit JS.<br />
            <pre>
  Pebble.addEventListener("webviewclosed", function(e){
    //Use the provided Master Key PIN to get relevant API keys, 
    //then store in localstorage.
    var config = JSON.parse(decodeURIComponent(e.response));

    var xhr = new XMLHttpRequest();
    var url = "https://pmkey.xyz/search/?pin=" + config.MasterKeyPIN;
  
    xhr.open("GET", url, true);
  
    xhr.onreadystatechanged = function(){
      if(xhr.readyState == 4 && xhr.status == 200){
        var result = JSON.parse(xhr.responseText);
        if(result.success && result.keys.weather.wu !== ""){
          localStorage.setItem("wuKey", result.keys.weather.wu);
        }
      }
    };
  
    xhr.send();
  }
            </pre>
          </label>
          <label class="item">
            <strong><font size="+2">Advanced Settings Page Example</font></strong><br />
            Below is HTML and Javascript code for a more advanced implementation of Master Key, using Slate, directly in your Settings page.<br />
            <pre>
  &lt;html&gt;
    &lt;head&gt;
      &lt;title&gt;My App Settings&lt;/title&gt;
      &lt;link rel="stylesheet" href="/dist/css/slate.min.css"&gt;
      &lt;script type="text/javascript" src="/dist/js/slate.min.js"&gt;&lt;/script&gt;
    &lt;/head&gt;
    &gt;body&lt;
      &lt;div class="item-container"&gt;
        &lt;div class="item-container-content"&gt;
          &lt;div class="item"&gt;
            Master Key allows your favorite Pebble watchfaces and apps to grab all your API keys via a simple 5-digit PIN code.&lt;br /&gt;
            To sign up, visit the &lt;a href="http://www.pmkey.xyz" target="_blank"&gt;Pebble Master Key Website&lt;/a&gt;.
          &lt;/div&gt;
          &lt;label class="item"&gt;
            &lt;div class="item-input-wrapper item-input-wrapper-button"&gt;
              &lt;input type="number" class="item-input" id="master"&gt;
            &lt;/div&gt;
            &lt;input type="button" class="item-button item-input-button" id="master-button" onclick="sync" value="SYNC"&gt;
          &lt;/label&gt;
        &lt;/div&gt;
        &lt;label class="item"&gt;
          &lt;div class="item-input-wrapper"&gt;
            &lt;input type="text" class="item-input" id="wu"&gt;
          &lt;/div&gt;
        &lt;/label&gt;
      &lt;/div&gt;

      &lt;script&gt;
        function sync(){
          var xhr = new XMLHttpRequest();
          var url = "https://pmkey.xyz/search/?pin=" + document.getElementById("master").value;

          xhr.open("GET", url, true);

          var masterSync = document.getElementById("master-button");
          masterSync.value = "LOADING...";

          xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
              if(result.success){
                masterSync.value = "SUCCESS";
                document.getElementById("wu").value = result.keys.weather.wu;
              }
              else{
                masterSync.value = "FAIL";
              }
            }
          };
        }
      &lt;/script&gt;
    &lt;/body&gt;
  &lt;/html&gt;
            </pre>
        </label>
    </div>
    <div class="item-container-footer">Master Key is a 3rd Party Service not affiliated with Pebble Technology Corp. All references to Pebble™ are purely for descriptive purposes.</div>
</body>
</html>
