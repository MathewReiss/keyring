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
    'html_body' => '<!DOCTYPE html><html xmlns=http://www.w3.org/1999/xhtml><meta content="text/html; charset=UTF-8"http-equiv=Content-Type><meta content="telephone=no"name=format-detection><meta content="width=device-width;initial-scale=1;maximum-scale=1;user-scalable=no;"name=viewport><meta content="IE=9; IE=8; IE=7; IE=EDGE"http-equiv=X-UA-Compatible><title>Page title</title><style>@import url(http://fonts.googleapis.com/css?family=Roboto:300);#outlook a{padding:0}body{width:100%!important;size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.backgroundTable{margin:0 auto;padding:0;width:100%}table td{border-collapse:collapse}.ExternalClass *{line-height:115%}@media screen and (max-width:630px){[class=mobile-column]{display:block}[class=mob-column]{float:none!important;width:100%!important}[class=hide]{display:none!important}[class="100p"]{width:100%!important;height:auto!important}[class=condensed]{padding-bottom:40px!important;display:block}[class=center]{text-align:center!important;width:100%!important;height:auto!important}[class="100pad"]{width:100%!important;padding:20px}[class="100padleftright"]{width:100%!important;padding:0 20px 0 20px}[class="100padtopbottom"]{width:100%!important;padding:20px 0 20px 0}}</style><body alink=#FFFFFF link=#FFFFFF style=padding:0;margin:0 vlink=#FFFFFF><table cellpadding=0 cellspacing=0 class=100p width=640 bgcolor=#><tr><td valign=top bgcolor=#3b464e class=100p width=640><!--[if gte mso 9]><v:rect xmlns:v=urn:schemas-microsoft-com:vml fill=true stroke=false style=width:640px><v:fill type=tile src=images/header-bg.jpg color=#3b464e><v:textbox style=mso-fit-shape-to-text:true inset=0,0,0,0><![endif]--><div><table cellpadding=20 cellspacing=0 border=0 class=100p width=640><tr><td valign=top><table cellpadding=0 cellspacing=0 border=0 class=100p width=600><tr><td height=10><tr><td align=center style=color:#FFF;font-size:24px><font face="\'Roboto\', Arial, sans-serif"><span style=font-size:44px>Thanks for signing up!</span><br><br><span style=font-size:24px>With Master Key, you\'ve just unlocked a world of possiblities.</span><br><br><span style=font-size:24px><em>Your Email is <strong>hello@email.com</strong>.</em></span><br><br><span style=font-size:24px><em>Your PIN is <strong>12345</strong>.</em></span><br><hr><span style=font-size:24px>See what watchfaces support Master Key!</span><br><br><table cellpadding=10 cellspacing=0 border=0 style="border:2px solid #FFF"><tr><td align=center style=color:#FFF;font-size:16px><font face="\'Roboto\', Arial, sans-serif"><a href=https://apps.getpebble.com/en_US/collection/master-key/watchfaces/1 style=color:#FFF;text-decoration:none>View Enabled Watchfaces</a></font></table></font><tr><td align=center style=color:#AAA;font-size:8px><font face="\'Roboto\', Arial, sans-serif"><br><br>For more information, visit <a href=https://pmkey.xyz style=text-decoration:none target=_blank>pmkey.xyz</a>.</font></table></table></div><!--[if gte mso 9]><![endif]--></table></body></html>'
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
