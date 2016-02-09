<?php
/**
* This page fetches data from the $_POST and sets them to their respective variables
*/

/**
* $post will contain an array of data submitted by the user that are present in $_POST
* $files will contain an array of data submitted by the user that are present in $_FILES
* $connectio will store the database connection
*/
function data($connection, $element) {
	if (isset($_POST[$element])) {
		return mysqli_real_escape_string($connection, trim($_POST[$element]));
	}
	else {
		return "";
	}
}
function set_data($post, $files, $connection) {
	// set data for $photo
	try
	{
		$path = getcwd();
		// check if the uploaded image is present in $_FILES
		if ($_FILES['photo']['name']) {
			$photo = basename($_FILES['photo']['name']);
			$imageFileType = pathinfo($path . '/images/'. $photo,PATHINFO_EXTENSION);
			// move the image to the server only if it is a .jpg, .png, .jprg or .gif
			if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
				move_uploaded_file($_FILES['photo']['tmp_name'], $path . "/images/" . $photo);
			}
			else {
				$photo = 'unknown extension';
			}
		}

		// check if the image was already in the $_SESSION
		else if ($_SESSION['photo']) {
			$photo = $_SESSION['photo'];
		}

		// if the image is neither in the $_FILES nor $_SESSION then set the default image for the user
		else {
			$photo = "userTile.png";
		}
	}
	catch (Exception $ex) {}

	// fetch user details from $post
	try
	{
		$record['userName'] = data($connection, 'userName');
	}
	catch (Exception $ex) {}

	try
	{
		$record['password'] = data($connection, 'password');
	}
	catch (Exception $ex) {}

	try
	{
		$record['reEnterPassword'] = data($connection, 'reEnterPassword');
	}
	catch (Exception $ex) {}

	$record['firstName'] = data($connection, 'firstName');
	$record['middleName'] = data($connection, 'middleName');
	$record['lastName'] = data($connection, 'lastName');
	$record['suffix'] = data($connection, 'suffix');
	$record['gender'] = data($connection, 'gender');
	$record['dateOfBirth'] = data($connection, 'dateOfBirth');
	$record['maritalStatus'] = data($connection, 'maritalStatus');
	$record['employmentStatus'] = data($connection, 'employmentStatus');
	$record['employer'] = data($connection, 'employer');
	$record['email'] = data($connection, 'email');
	
	$record['street'] = data($connection, 'street');
	$record['city'] = data($connection, 'city');
	$record['state'] = data($connection, 'state');
	$record['zip'] = data($connection, 'zip');
	$record['telephone'] = data($connection, 'telephone');
	$record['mobile'] = data($connection, 'mobile');
	$record['fax'] = data($connection, 'fax');

	$record['officeStreet'] = data($connection, 'officeStreet');
	$record['officeCity'] = data($connection, 'officeCity');
	$record['officeState'] = data($connection, 'officeState');
	$record['officeZip'] = data($connection, 'officeZip');
	$record['officeTelephone'] = data($connection, 'officeTelephone');
	$record['officeMobile'] = data($connection, 'officeMobile');
	$record['officeFax'] = data($connection, 'officeFax');

	try {
		$record['optionEmail'] =  data($connection, 'optionEmail');
	}
	catch (Exception $e) {
		$record['optionEmail'] = 0;
	}

	try {
		$record['optionMessage'] =  data($connection, 'optionMessage');
	}
	catch (Exception $e) {
		$record['optionMessage'] = 0;
	}

	try {
		$record['optionPhone'] =  data($connection, 'optionPhone');
	}
	catch (Exception $e) {
		$record['optionPhone'] = 0;
	}

	try {
		$record['optionAny'] =  data($connection, 'optionAny');
	}
	catch (Exception $e) {
		$record['optionAny'] = 0;
	}

	$record['moreAboutYou'] = addslashes( data($connection, 'moreAboutYou'));

	try
	{
		$record['photo'] = $photo;
	}
	catch (Exception $ex){}
	return $record;
}
?>