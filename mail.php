<?php
/**
* This page is used to send mails.
*/
// Turn on error reporting
ini_set('display_errors','On');
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'includes/PHPMailerAutoload.php';

// email credentials (change these if you need to use another own email id)
$userName = "neerajkumardas7@gmail.com";
$password = "@pp1e@pp1e";

// check if a user is signed in
if (isset($_SESSION['id'])) {

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 1;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->Username = $userName;
	$mail->Password = $password;
	$mail->SetFrom("$userName");

	//fetch details from the session if present
	try
	{
		$mail_to = $_SESSION['mail_to'];
		$mail_body = $_SESSION['mail_body'];
		$message = $_SESSION['message'];
		$subject = $_SESSION['subject'];
	}
	catch (Exception $ex) { }

	$mail->Subject = "$subject";
	$mail->Body = "$mail_body";
	$mail->AddAddress("$mail_to");
	
	// end session that was used to carry email information
	session_unset();
	session_destroy();

	// send email and start a session to carry out a message to be given to the user 
	// about success or failure of the email
	if(!$mail->Send()) {
		session_start();
		$_SESSION['message'] = "Unable to send mail";
		header("Location: index.php");
	} 
	else {
		session_start();
		$_SESSION['message'] = $message;
		header("Location: index.php");
	}
}
else {
	header("Location: index.php");
}
?>