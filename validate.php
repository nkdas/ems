<?php
/**
* This callingPage acts as the registration callingPage for new users
* @author Neeraj Kumar Das <neeraj.das@mindfiresolutions.com>
*/

// Turn on error reporting
ini_set('display_errors','On');
error_reporting(E_ALL);

require_once('resources/db_connection.php');

/**
* $record will contain an array of data submitted by the user
* $connection will store the database connection
* $callingPage will indicate which page is requesting a validation (registration page or the edit page)
*/

function validate($record, $connection, $callingPage) {

	//array to store the errors.
	$errors = array();
	//i serves as the key or index to the array $errors.
	$i = 1;

	// validate photo
	if ($record['photo'] == 'unknown extension') {
		$errors[$i] = "Only JPG, JPEG, PNG & GIF files are allowed as profile photo.";
		$i++;
	}
	else {
		$_SESSION['photo'] = $record['photo'];
	}

	// only the registeration callingPage requires validations for userName and password
	if($callingPage == "register") {

		if (empty($record['userName'])) {
			$errors[$i] = "You must enter a userName";
			$i++;
		}
		// check the length of the userName entered
		else if (strlen($record['userName']) < 6) {
			$errors[$i] = "userName must be of atleast 6 characters";
			$i++;
		}

		// check if the userName is already being used by someone
		$userName = $record['userName'];
		$query = mysqli_query($connection, "SELECT id FROM employee_details WHERE userName = '$userName'");
		if ($query and $row = mysqli_fetch_assoc($query)) {
			$errors[$i] = "This userName is already taken, Please use another";
			$i++;
		}

		if (empty($record['password'])) {
			$errors[$i] = "You must enter your password";
			$i++;
		}
		// check the length of the password
		else if (strlen($record['password']) < 6) {
			$errors[$i] = "Passwords must be of at least 6 characters";
			$i++;
		}
		// check if both the passwords entered by the user match
		if($record['password'] != $record['reEnterPassword']) {
			$errors[$i] = "Passwords entered in the 'Password' and 'Re-enter Password' fields donot match";
			$i++;
		}
	}

	// check for firstName
	if (empty($record['firstName'])) {
		$errors[$i] = "You must enter your First name";
		$i++;
	}
	else if (ctype_alpha($record['firstName']) === false) {
		$errors[$i] = "A name must contain only characters";
		$i++;
	}

	// check for lastName
	if (empty($record['lastName'])) {
		$errors[$i] = "You must enter your Last name";
		$i++;
	}
	else if (ctype_alpha($record['lastName']) === false) {
		$errors[$i] = "A name must contain only characters";
		$i++;
	}

	// chec for date of birth
	if (empty($record['dateOfBirth'])) {
		$errors[$i] = "You must enter your date of birth";
		$i++;
	}

	// check for employer
	if (empty($record['employer'])) {
		$errors[$i] = "You must enter your Employer";
		$i++;
	}

	// validate email
	if (!preg_match('/^[a-z0-9_-]+@[a-z0-9._-]+\.[a-z]+$/i', $record['email'])) {
		$errors[$i] = "Please enter a valid email";
	}

	// check if the email is already being used by someone
	$email = $record['email'];
	if($callingPage == "update") {
		$userId = $_SESSION['id'];
		$query = mysqli_query($connection, "SELECT id 
			FROM employee_details
			WHERE email = '$email' AND  id != $userId ");
		if ($query and $row = mysqli_fetch_assoc($query)) {
			$errors[$i] = "This email id is already taken, Please use another";
			$i++;
		}
	}
	else
	{
		$query = mysqli_query($connection, "SELECT id 
				FROM employee_details
				WHERE email = '$email'");
		if ($query and $row = mysqli_fetch_assoc($query)) {
			$errors[$i] = "This email id is already taken, Please use another";
			$i++;
		}
	}

	if (empty($record['gender'])) {
		$errors[$i] = "You must select your Gender";
		$i++;
	}

	if (empty($record['street'])) {
		$errors[$i] = "You must enter your Residential Street";
		$i++;
	}

	if (empty($record['city'])) {
		$errors[$i] = "You must enter your Residential City";
		$i++;
	}
	else if (ctype_alpha($record['city']) === false) {
		$errors[$i] = "A city name must contain only characters";
		$i++;
	}

	if (empty($record['state'])) {
		$errors[$i] = "You must enter your Residential State";
		$i++;
	}
	else if (ctype_alpha($record['state']) === false) {
		$errors[$i] = "A state name must contain only characters";
		$i++;
	}

	if (empty($record['zip'])) {
		$errors[$i] = "You must enter your Residential Zip";
		$i++;
	}
	else if (ctype_digit($record['zip']) === false) {
		$errors[$i] = "A zip must contain only digits";
		$i++;
	}

	if (empty($record['telephone'])) {
		$errors[$i] = "You must enter your Residential Telephone number.
		If you donot have one, then enter your mobile number in both the fields";
		$i++;
	}
	else if (ctype_digit($record['telephone']) === false) {
		$errors[$i] = "A telephone number must contain only digits";
		$i++;
	}
	else if ( !(strlen($record['telephone']) == 10)) {
		$errors[$i] = "A telephone number must be of 10 digits";
		$i++;
	}

	if (empty($record['mobile'])) {
		$errors[$i] = "You must enter your Residential Mobile number. 
		If you donot have one, then enter your telephone number in both the fields";
		$i++;
	}
	else if (ctype_digit($record['mobile']) === false) {
		$errors[$i] = "A mobile number must contain only digits";
		$i++;
	}
	else if ( !(strlen($record['mobile']) == 10)) {
		$errors[$i] = "A mobile number must be of 10 digits";
		$i++;
	}
	return $errors;
}

/**
* function to check uniqueness of userName and email id as soon as user leaves the input field
*/
 if (isset($_POST['function']) && 'check_uniqueness' == $_POST['function']) {
    check_uniqueness();
}

function check_uniqueness() {
	global $connection;
	$element = $_POST['element'];
	$elementValue = $_POST['elementValue'];
	$flag = 1;

	// if we are checking for email uniqueness while the user is editing then we must skip the email id which the user is already using
	if (($_POST['callingPage'] == 'edit') && ($element ==  'email')) {
		$userId = $_SESSION['id'];
		$query = mysqli_query($connection, "SELECT id 
			FROM employee_details
			WHERE email = '$elementValue' AND  id != $userId ");
		if ($query and $row = mysqli_fetch_assoc($query)) {
			$flag = 1;
		}
		else {
			$flag = 2;
		}
	}
	else {
		$query = mysqli_query($connection, "SELECT id 
				FROM employee_details
				WHERE $element = '$elementValue'");
		if ($query and $row = mysqli_fetch_assoc($query)) {
			$flag = 1;
		} 
		else {
			$flag = 2;
		}
	}
	if ($flag == 1) {
		$status = array('status' => '1');
		echo json_encode($status);
	}
	else {
		$status = array('status' => '2');
		echo json_encode($status);
	}
}
?>