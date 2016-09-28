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

$email = 'mathewreiss@gmail.com';
$pin = '12345';

$sent = send_email(array(
    'to' => $email,
    'from' => 'PIN Bot <donotreply@pmkey.xyz>',
    'subject' => 'That was easy',
    'text_body' => 'Your email is ' . $email . ' and your PIN is ' . $pin . '.',
    'html_body' => '<html><body>Your email is <em>' . $email . '</em> and your PIN is <strong>' . $pin . '</strong>.</body></html>'

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