<?php
/**
* This page takes user credentials and checks with the database if the credentials are true,
* If true it sets sessions for the user and returns 1 as authentication success to the ajax call.
*/

// Turn on error reporting
ini_set('display_errors','On');
error_reporting(E_ALL);

require_once('resources/db_connection.php');

// fetch userName and password from $_POST
$userName = mysqli_real_escape_string($connection, trim($_POST['userName']));
$password = mysqli_real_escape_string($connection, trim($_POST['password']));
$password = md5($password);

$query = mysqli_query($connection, "SELECT id, activationStatus
    FROM employee_details 
    WHERE userName = '$userName' AND password = '$password'");

// if the query executes successfully then the user is registered and the credentials are valid
if ($query and $row = mysqli_fetch_assoc($query)) {
    // check if the account of the registered user is activated

    if($row['activationStatus'] == 1) {
        
        // if the account of the user is activated, then create sessions for the user and display the users home page.
        $_SESSION['id'] = $row['id'];
        $status = array('status' => '1');
        echo json_encode($status);
    }
    else {
        $status = array('status' => '2');
        echo json_encode($status);
    }
}
else
{
    $status = array('status' => '3');
    echo json_encode($status);
}
?>