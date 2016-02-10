<?php
require_once('resources/db_connection.php');

interface DataFunctions {
    public function setData($post, $files);
    public function validateData($record, $callingPage);
}

class ProcessData implements DataFunctions {
    function setDefaultValues() {
        $record = array(
            'photo' => 'userTile.png',
            'userName' => '',
            'password' => '',
            'firstName' => '',
            'middleName' => '',
            'lastName' => '',
            'suffix' => '',
            'gender' => '',
            'dateOfBirth' => '',
            'maritalStatus' => '',
            'employmentStatus' => '',
            'employer' => '',
            'email' => '',
            'street' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'telephone' => '',
            'mobile' => '',
            'fax' => '',
            'officeStreet' => '',
            'officeCity' => '',
            'officeState' => '',
            'officeZip' => '',
            'officeTelephone' => '',
            'officeMobile' => '',
            'officeFax' => '',
            'optionEmail' => 0,
            'optionMessage' => 0,
            'optionPhone' => 0,
            'optionAny' => 0,
            'moreAboutYou' => ''
        );
        return $record;
    }

    public function setData($post, $files) {
        $record = $this->setDefaultValues();
        global $connection;
        foreach($post as $element => $value) {
            $record[$element] = addslashes(mysqli_real_escape_string($connection, trim($value)));
        }

        // set Data for $photo
        try
        {
            $path = getcwd();

            // check if the uploaded image is present in $_FILES
            if (isset($files['photo']['name']) && ($files['photo']['name'] != '')) {
                $photo = basename($files['photo']['name']);
                $imageFileType = pathinfo($path . '/images/'. $photo,PATHINFO_EXTENSION);
                
                // move the image to the server only if it is a .jpg, .png, .jprg or .gif
                if($imageFileType == 'jpg' || $imageFileType == 'png' || $imageFileType == 'jpeg' || 
                    $imageFileType == 'gif' ) {
                    move_uploaded_file($files['photo']['tmp_name'], $path . '/images/' . $photo);
                    $record['photo'] = $photo;
                }
                else {
                    $record['photo'] = 'unknown extension';
                }
            }

            // check if the image was already in the $_SESSION
            else if (isset($_SESSION['photo'])) {
                $record['photo'] = $_SESSION['photo'];
            }
        }
        catch (Exception $ex) {
            $record['photo'] = 'unable to set';
        }

        return $record;
    }

    public function validateData($record, $callingPage) {
        
        $errors = array();
        $i = 1;
        if ($callingPage == 'register') {
            // username
            if (strlen($record['userName']) < 6) {
                $errors[$i] = "userName must be of atleast 6 characters";
                $i++;
            }
            else {
                $availability = $this->checkUniqueness('userName',$record['userName'],'register');
                if ('unavailable' == $availability) {
                    $errors[$i] = "This username is already taken";
                    $i++;
                }
            }
            // password
            if (strlen($record['password']) < 6) {
                $errors[$i] = "Passwords must be of at least 6 characters";
                $i++;
            }
            // check if both the passwords entered by the user match
            if($record['password'] != $record['reEnterPassword']) {
                $errors[$i] = "Passwords entered in the 'Password' and 'Re-enter Password' fields donot match";
                $i++;
            }
        }

        if ($record['photo'] == 'unknown extension') {
            $errors[$i] = "Only JPG, JPEG, PNG & GIF files are allowed as profile photo.";
            $i++;
        }
        else {
            $_SESSION['photo'] = $record['photo'];
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

        // check for date of birth
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
        else {
            if($callingPage == "update") { 
                $availability = $this->checkUniqueness('email',$record['email'],'update');
            }
            else {
                $availability = $this->checkUniqueness('email',$record['email'],'register');
            }
            if ('unavailable' == $availability) {
                $errors[$i] = "This email id is already taken";
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

    function checkUniqueness($element, $elementValue, $callingPage, $origin = 'nonAjax') {
        global $connection;
        $emailAvailability = 'unavailable';

        // if we are checking for email uniqueness while the user is editing then we must skip the email 
        // id which the user is already using

        $condition = '';
        $conditionValue = '';
       
        if (('update' == $callingPage) && ('email' == $element)) {

            if (isset($_SESSION['userName'])) {
                $condition = 'userName';
                $conditionValue = $_SESSION['userName'];
            }
            else {
                $condition = 'id';
                $conditionValue = $_SESSION['id'];
            }
            
            $query = mysqli_query($connection, "SELECT id 
                FROM employee_details
                WHERE email = '$elementValue' AND  $condition != '$conditionValue' ");
            if ($query and $row = mysqli_fetch_assoc($query)) {
                $emailAvailability = 'unavailable';
            }
            else {
                $emailAvailability = 'available';
            }
        }
        else {
            $query = mysqli_query($connection, "SELECT id 
                    FROM employee_details
                    WHERE $element = '$elementValue'");
            if ($query and $row = mysqli_fetch_assoc($query)) {
                $emailAvailability = 'unavailable';
            } 
            else {
                $emailAvailability = 'available';
            }
        }

        if ('unavailable' == $emailAvailability) {
            if ('nonAjax' == $origin) {
                return 'unavailable';
            }
            else {
                $status = array('status' => 'unavailable');
                echo json_encode($status);
            }
        }
        else {
            if ('nonAjax' == $origin) {
                return 'available';
            }
            else {
                $status = array('status' => 'available');
                echo json_encode($status);
            }
        }
    }
}

if (isset($_POST['function']) && 'checkUniqueness' == $_POST['function']) {
    $processData = new ProcessData;
    $processData->checkUniqueness($_POST['element'],$_POST['elementValue'],$_POST['callingPage'],'ajax');
}

?>