<?php 
require_once('db_connection.php');

$userName = mysqli_real_escape_string($connection, trim($_POST['userName']));
$query = mysqli_query($connection, "DELETE FROM employee_details 
	WHERE userName = '$userName'");
if ($query) {
	$status = array('status' => '1');
	echo json_encode($status);
}
else {
	$status = array('status' => '2');
	echo json_encode($status);
}
?>