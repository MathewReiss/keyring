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
            Below is HTML and Javascript code for a simple implementation of Master Key in your Settings page.<br />
            <pre>
  &lt;html&gt;
  &lt;/html&gt;
            </pre>
          </label>
          <label class="item">
            <strong><font size="+2">Advanced Settings Page Example</font></strong><br />
            Below is HTML and Javascript code for a more advanced implementation of Master Key in your Settings page.<br />
            <pre>
  &lt;html&gt;
  &lt;/html&gt;
            </pre>
        </label>
    </div>
    <div class="item-container-footer">Master Key is a 3rd Party Service not affiliated with Pebble Technology Corp. All references to Pebble™ are purely for descriptive purposes.</div>
</body>
</html>
