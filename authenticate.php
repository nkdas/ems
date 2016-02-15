<?php
/**
* This page takes user credentials and checks with the database if the credentials are true,
* If true it sets sessions for the user and returns 1 as authentication success to the ajax call.
*/
require_once 'resources/db_connection.php';

// fetch userName and password from $_POST
$userName = mysqli_real_escape_string($connection, trim($_POST['userName']));
$password = mysqli_real_escape_string($connection, trim($_POST['password']));
$page = mysqli_real_escape_string($connection, trim($_POST['page']));
$password = md5($password);
$query = null;

if ($page == 'user') {
    $query = mysqli_query(
        $connection,
        "SELECT id, activationStatus
        FROM employee_details 
        WHERE userName = '$userName' AND password = '$password'"
    );
} else {
    $query = mysqli_query(
        $connection,
        "SELECT pk_admin
        FROM admin 
        WHERE userName = '$userName' AND password = '$password'"
    );
}

// if the query executes successfully then the user is registered and the credentials are valid
if ($query and $row = mysqli_fetch_assoc($query)) {
    if ($page == 'user') {
        // check if the account of the registered user is activated
        if ($row['activationStatus'] == 1) {

            // if the account of the user is activated, then create sessions for the user and
            // display the users home page.
            $_SESSION['id'] = $row['id'];
            $status = array('status' => 'login success');
            echo json_encode($status);
        } else {
            $status = array('status' => 'inactive account');
            echo json_encode($status);
        }
    } else {
        $_SESSION['pk_admin'] = $row['pk_admin'];
        $status = array('status' => 'admin login success');
        echo json_encode($status);
    }
} else {
    $status = array('status' => 'invalid credentials');
    echo json_encode($status);
}
