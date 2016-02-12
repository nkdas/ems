<?php
/**
* This page activates a registered user by matching the ID and Key from url with the once 
* in the database 
* and sets the activation field in the database to 1 thereby activating the user.
*/
require_once('resources/db_connection.php');

// get user id and activation key from the the url
try {
    $userId = $_GET['id'];
    $activationKey = $_GET['key'];

    // check if both id and activation key belong to the same user
    $query= mysqli_query($connection, "SELECT userName 
                                        FROM employee_details 
                                        WHERE activationKey = '$activationKey' AND id = '$userId'");
    if ($query and $row = mysqli_fetch_assoc($query)) {

        // update the activation field of the user employee_details to 1
        $query = mysqli_query($connection, "UPDATE employee_details 
                                            SET activationStatus = 1
                                            WHERE id = $userId");

        // if updation is successful, it means the user is activated
        // redirect to index page and show a message that the account is activated
        if($query) {
            $_SESSION['message'] = "Your account is activated!<br>You are ready to Sign in.";
            header("Location: index.php");
        }
    }
}
catch (Exception $ex) {
    $_SESSION['message'] = "Sorry! Unable to process your request.";
    header("Location: index.php");
}
?>