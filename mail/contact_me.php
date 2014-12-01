<?php

require_once("../config.php");


// Check for empty fields
if(empty($_POST['name'])  		||
    empty($_POST['email']) 		||
    empty($_POST['phone']) 		||
    empty($_POST['message'])	||
    !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
{
    echo "No arguments Provided!";
    return false;
}

$mandrill = new Mandrill(MANDRILL_PASSWORD);

$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Create the email and send the message
$to = 'logicalliving@logicalliving.org'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "[Website Contact Form]  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
$headers = "From: noreply@logicalliving.org\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";

$message = [
    'html' => $message,
    'text' => $message,
    'subject' => $email_subject,
    'from_email' => 'noreply@logicalliving.org',
    'to' => [
        [
            'email' => $to,
            'type' => 'to'
        ]
    ],
    'headers' => ['Reply-to' => $email_address]
];

$result = $mandrill->messages->send($message);
print_r($result);
//mail($to,$email_subject,$email_body,$headers);
return true;
