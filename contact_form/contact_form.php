<?php

// configure
$from = 'kavish.soningra@tcu.edu'; // Replace it with Your Hosting Admin email. REQUIRED!
$sendTo = 'kavish.soningra@tcu.edu'; // Replace it with Your email. REQUIRED!
$subject = 'New message from contact form';
$fields = array('name' => 'Name', 'email' => 'Email', 'subject' => 'Subject', 'message' => 'Message'); // array variable name => Text to appear in the email. If you added or deleted a field in the contact form, edit this array.
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

try
{
    $emailText = nl2br("You have new message from Contact Form\n");

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= nl2br("$fields[$key]: $value\n");
        }
    }

    $headers = array('Content-Type: text/html; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );

    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}

?>

