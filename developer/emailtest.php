<?php

define('POSTMARK_API_KEY', "$_ENV[POSTMARK_API_KEY]");

function send_email($email, &$response = null, &$http_code = null) {
    $json = json_encode(array(
        'From' => $email['from'],
        'To' => $email['to'],
        'Cc' => $email['cc'],
        'Bcc' => $email['bcc'],
        'Subject' => $email['subject'],
        'Tag' => $email['tag'],
        'HtmlBody' => $email['html_body'],
        'TextBody' => $email['text_body'],
        'ReplyTo' => $email['reply_to'],
        'Headers' => $email['headers'],
        'Attachments' => $email['attachments']
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

$sent = send_email(array(
    'to' => 'mathewreiss@gmail.com',
    'from' => 'PIN Bot <donotreply@pmkey.xyz>',
    'subject' => 'Master Key PIN',
    'text_body' => 'Thank you for signing up for Master Key! Your email address is "hello@email.com" and your PIN is "12345".',
    'html_body' => '
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
                                                        <td height="10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="color:#FFFFFF; font-size:24px;">
                                                            <font face="'Roboto', Arial, sans-serif">
                                                                <span style="font-size:44px;">Thanks for signing up!</span><br />
                                                                <br />
                                                                <Span style="font-size:24px;">With Master Key, you've just unlocked a world of possiblities.</Span>
                                                                <br /><br />
																
																<Span style="font-size:24px;"><em>Your Email is <strong>hello@email.com</strong>.</em></Span>
                                                                <br /><br />

																<Span style="font-size:24px;"><em>Your PIN is <strong>12345</strong>.</em></Span>
                                                                <br />
                                                                <hr />

                                                                <Span style="font-size:24px;">See what watchfaces support Master Key!</Span>
                                                                <br /><br />


                                                                <table border="0" cellspacing="0" cellpadding="10" style="border:2px solid #FFFFFF;">
                                                                    <tr>
                                                                        <td align="center" style="color:#FFFFFF; font-size:16px;"><font face="'Roboto', Arial, sans-serif"><a href="https://apps.getpebble.com/en_US/collection/master-key/watchfaces/1" style="color:#FFFFFF; text-decoration:none;">View Enabled Watchfaces</a></font></td>
                                                                    </tr>
                                                                </table>

                                                            </font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="color:#AAAAAA; font-size:8px;"><font face="'Roboto', Arial, sans-serif"><br /><br />For more information, visit <a href="https://pmkey.xyz"  target="_blank" style="text-decoration: none">pmkey.xyz</a>.</font></td>
                                                    </tr>
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
// Did it send successfully?
if( $sent ) {
    echo 'The email was sent!';
} else {
    echo 'The email could not be sent!';
}
// Show the response and HTTP code
echo '<pre>';
echo 'The JSON response from Postmark:<br />';
print_r($response);
echo 'The HTTP code was: ' . $http_code;
echo '</pre>';

?>
