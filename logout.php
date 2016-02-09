<?php
/**
* This page unsets the session and signs out a user
*/

session_start();
session_unset();
session_destroy();

session_start();
$_SESSION['message'] = "You have signed out successfully";
header("Location: index.php");
?>