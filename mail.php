<?php
/**
* This page is used to send mails.
*/
// Turn on error reporting
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'includes/PHPMailerAutoload.php';

function sendMail($mailTo, $mailSubject, $mailBody)
{
    global $mail;
    // email credentials (change these if you need to use another own email id)
    $userName = '';
    $password = '';

    // check if a user is signed in
    if (isset($_SESSION['id'])) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = $userName;
        $mail->Password = $password;
        $mail->SetFrom("$userName");

        $mail->Subject = "$mailSubject";
        $mail->Body = "$mailBody";
        $mail->AddAddress("$mailTo");

        // end session that was used to carry email information
        unset($_SESSION['id']);

        // send email and start a session to carry out a message to be given to the user
        // about success or failure of the email
        if (!$mail->Send()) {
            return 'failed';
        } else {
            return 'success';
        }
    } else {
        header('Location: index.php');
    }
}
