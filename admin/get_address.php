<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');

$output = array("aaData" => array());

$query = mysqli_query($connection, "SELECT firstName, middleName, lastName, email, street, city, state, zip
                FROM employee_details");
if ($query) {
	$row = array();
	$name = array();
	$email = array();
	$i = 0;
    while ($record = mysqli_fetch_assoc($query)) {
        $address = $record['street'] . "," . $record['city'] . "," . 
        			$record['state'] . "," . $record['zip'];
        
        $name[$i] = $record['firstName'] . " " . $record['middleName'] . " " . $record['lastName'];
        $email[$i] = $record['email'];
        $row[$i] = $address;
        $i++;
         
    }

   echo json_encode( array("address" => $row, "employeeName" => $name, "email" => $email) );

}
?>