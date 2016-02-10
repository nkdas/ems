<?php
/**
* This page provides database functions
*/

require('mail.php');
// function to insert a record while registration
function insert_record($record, $connection) {
	// prepare statement
	$statement = $connection->prepare(
		"INSERT INTO employee_details (userName, password, firstName, middleName, lastName, suffix, gender, dateOfBirth, maritalStatus, employmentStatus, 
			employer, email, street, city, state, zip, telephone, mobile, fax, officeStreet, officeCity, officeState, officeZip, officeTelephone, 
			officeMobile, officeFax, optionEmail, optionMessage, optionPhone, optionAny, moreAboutYou, photo)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
	);

	if($statement) {
		// bind parameters
		$statement->bind_param("ssssssisssssssssssssssssssiiiiss", 
			$record['userName'], $record['password'], $record['firstName'], $record['middleName'], $record['lastName'], $record['suffix'], 
			$record['gender'], $record['dateOfBirth'], $record['maritalStatus'], $record['employmentStatus'], $record['employer'], $record['email'], 
			$record['street'], $record['city'], $record['state'], $record['zip'], $record['telephone'], $record['mobile'], $record['fax'], 
			$record['officeStreet'], $record['officeCity'], $record['officeState'], $record['officeZip'], $record['officeTelephone'], $record['officeMobile'], 
			$record['officeFax'], $record['optionEmail'], $record['optionMessage'], $record['optionPhone'], $record['optionAny'], $record['moreAboutYou'], 
			$record['photo']);

		 // execute query to insert data into the database
		if($statement->execute()) {
			$userName = $record['userName'];
			$query= mysqli_query($connection, "SELECT id 
				FROM employee_details 
				WHERE userName = '$userName'");
			if ($query and $row = mysqli_fetch_assoc($query)) {

				$key = md5($row['id']);
				//if insertion to the database completed successfully
				$query2 = mysqli_query($connection, "UPDATE employee_details SET activationKey = '$key' WHERE userName = '$userName' "); 

				$_SESSION['id'] = $row['id'];

				$mailTo = $record['email'];
				$mailSubject = "Account activation";
				$mailBody = "Hi " . $record['firstName'] . 
				"!<br>Thank you for registering to EMS<br>
				Please follow the link below to activate your account:<br>
				<a href='http://localhost/ems/activation.php?id=" . $row['id'] . "&key=" . $key . "'>
				Activate my account</a>";

				$status = sendMail($mailTo, $mailSubject, $mailBody);

				return $status;
			}
			else {
				return 'Registration failed';
			}		
		}
		else {
			return 'Registration failed';
		}
	}
	else {
		return 'Registration failed';
	}
}

// function to update the record of a user
function update_record($userId, $connection, $record) {	
	$query = "UPDATE employee_details 
	SET firstName = '" . $record['firstName'] . "', middleName = '" . $record['middleName'] . "', lastName = '" . $record['lastName'] . 
	"', suffix = '" . $record['suffix'] . "', gender = '" . $record['gender'] . "', dateOfBirth = '" . $record['dateOfBirth'] . 
	"', maritalStatus = '" . $record['maritalStatus'] . "', employmentStatus = '" . $record['employmentStatus'] . "',employer = '" . $record['employer'] . 
	"', email = '" . $record['email'] . "', street = '" . $record['street'] . "', city = '" . $record['city'] . "', state = '" . $record['state'] . 
	"', zip = '" . $record['zip'] . "', telephone = '" . $record['telephone'] . "', mobile = '" . $record['mobile'] . "', fax = '" . $record['fax'] . 
	"', officeStreet = '" . $record['officeStreet'] . "', officeCity = '" . $record['officeCity'] . "',officeState = '" . $record['officeState'] . "', officeZip = '" . $record['officeZip'] . 
	"', officeTelephone = '" . $record['officeTelephone'] . "', officeMobile = '" . $record['officeMobile'] . "', officeFax = '" . $record['officeFax'] . 
	"',optionEmail = '" . $record['optionEmail'] . "', optionMessage = '" . $record['optionMessage'] . "', optionPhone = '" . $record['optionPhone'] . 
	"',optionAny = '" . $record['optionAny'] . "', moreAboutYou = '" . $record['moreAboutYou'] . "', photo = '" . $record['photo'] . 
	"' WHERE id = $userId";
	$sql = mysqli_query($connection, $query);

	if($sql) {
		return 1;
	}
	else {
		return 2;
	}
}

// function to retrieve record from the database and send to editing form
function get_record_for_updation($userId, $connection) {	
	$query = mysqli_query($connection, "SELECT userName, password, firstName, middleName, lastName, suffix, gender, dateOfBirth, maritalStatus, employmentStatus, employer, email, 
		street, city, state, zip, telephone, mobile, fax, officeStreet, officeCity, officeState, officeZip, officeTelephone, officeMobile, officeFax,
		optionEmail, optionMessage, optionPhone, optionAny, moreAboutYou, photo
		FROM employee_details
		WHERE id = $userId");
	if ($query and $row = mysqli_fetch_assoc($query)) { 
		$_SESSION['photo'] = $row['photo'];
	}
	return $row;
}
?>