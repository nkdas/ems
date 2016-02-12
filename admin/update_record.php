<?php
require_once('db_connection.php');

$userName = mysqli_real_escape_string($connection, trim($_POST['userName']));
$record['firstName'] = mysqli_real_escape_string($connection, trim($_POST['firstName']));
$record['middleName'] = mysqli_real_escape_string($connection, trim($_POST['middleName']));
$record['lastName'] = mysqli_real_escape_string($connection, trim($_POST['lastName']));
$record['suffix'] = mysqli_real_escape_string($connection, trim($_POST['suffix']));
$record['gender'] = mysqli_real_escape_string($connection, trim($_POST['gender']));
$record['dateOfBirth'] = mysqli_real_escape_string($connection, trim($_POST['dateOfBirth']));
$record['maritalStatus'] = mysqli_real_escape_string($connection, trim($_POST['maritalStatus']));
$record['employmentStatus'] = mysqli_real_escape_string($connection, 
trim($_POST['employmentStatus']));
$record['employer'] = mysqli_real_escape_string($connection, trim($_POST['employer']));
$record['email'] = mysqli_real_escape_string($connection, trim($_POST['email']));

$record['street'] = mysqli_real_escape_string($connection, trim($_POST['street']));
$record['city'] = mysqli_real_escape_string($connection, trim($_POST['city']));
$record['state'] = mysqli_real_escape_string($connection, trim($_POST['state']));
$record['zip'] = mysqli_real_escape_string($connection, trim($_POST['zip']));
$record['telephone'] = mysqli_real_escape_string($connection, trim($_POST['telephone']));
$record['mobile'] = mysqli_real_escape_string($connection, trim($_POST['mobile']));
$record['fax'] = mysqli_real_escape_string($connection, trim($_POST['fax']));

$query = "UPDATE employee_details 
    SET firstName = '" . $record['firstName'] . "', middleName = '" . $record['middleName'] . 
    "', lastName = '" . $record['lastName'] . "', suffix = '" . $record['suffix'] . "', gender = 
    '" . $record['gender'] . "', dateOfBirth = '" . $record['dateOfBirth'] . "', maritalStatus = 
    '" . $record['maritalStatus'] . "', employmentStatus = '" . $record['employmentStatus'] . 
    "',employer = '" . $record['employer'] . "', email = '" . $record['email'] . "', street = 
    '" . $record['street'] . "', city = '" . $record['city'] . "', state = '" . $record['state'] . 
    "', zip = '" . $record['zip'] . "', telephone = '" . $record['telephone'] . "', mobile = 
    '" . $record['mobile'] . "', fax = '" . $record['fax'] . "' WHERE userName = '$userName'";
    $sql = mysqli_query($connection, $query);

    if($sql) {
        $status = array('status' => '1');
        echo json_encode($status);
    }
    else {
        $status = array('status' => $connection->error);
        echo json_encode($status);
    }
?>