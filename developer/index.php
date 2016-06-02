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
<body>
  <div class="item-container">
      <div class="item-container-header">Pebble Master Key</div>
      <div class="item-container-content">
        <label class="item">
            Master Key makes it easier than ever to ask your users to provide their own API keys for services with strict rate-limits. Rather than asking for a long Weather Underground API Key, for example, all you need from your user is their 5-digit Master Key PIN.<br /><br />
            <strong>API Endpoint</strong><br />
            To get the relevant API keys, simply call the following URL via HTTP GET: <pre>https://pmkey.xyz/search?pin=10000</pre>.<br /><br />
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
            <br /><br />
            Keep in mind that any one of these keys could be returned as an empty string.
            <br /><br />
            <strong>Simple Settings Page Example</strong><br />
            Below is HTML and Javascript code for a simple implementation of Master Key in your Settings page.<br /><br />
            <pre>
              &lt;html&gt;
              &lt;/html&gt;
            </pre>
            <br /><br />
            <strong>Advanced Settings Page Example</strong><br />
            Below is HTML and Javascript code for a more advanced implementation of Master Key in your Settings page.<br /><br />
            <pre>
              &lt;html&gt;
              &lt;/html&gt;
            </pre>
        </label>

    </div>
    <div class="item-container-footer">Master Key is a 3rd Party Service not affiliated with Pebble Technology Corp. All references to Pebble™ are purely for descriptive purposes.</div>
</body>
</html>
