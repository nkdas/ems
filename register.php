<?php
/**
* This page acts as the registration page for new users
* @author Neeraj Kumar Das <neeraj.das@mindfiresolutions.com>
*/

// Turn on error reporting
ini_set('display_errors','On');
error_reporting(E_ALL);

// start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('resources/db_connection.php');
require('db_functions.php');
require('process_data.php');

// check if profile photo's file name is present in the session
if (!isset($_SESSION['photo'])) {
    $photo = "";
}

// if the user has submitted the form
if (isset($_POST['submit'])) {

    $processData = new ProcessData;
    $record = $processData->setData($_POST, $_FILES, $connection);

    // set session to store the name of the photo so that we can have the photo during resubmission 
    // (in case of validation errors)
    $_SESSION['photo'] = $record['photo'];
    
    // validate data in $record
    $errors = $processData->validateData($record, $connection, "register");
    
    // if no error exists after validation then encrypt the passwords and
    // enter the details to the database.
    if (!$errors) {
        $record['password'] = md5($record['password']);
        $status = insert_record($record, $connection);
        if ('success' == $status) {
            $_SESSION['message'] = "Registration successful!<br>Please check your email to activate 
                your account.";
        }
        else if ('failed' == $status) {
            $_SESSION['message'] = "Unable to send mail.";
        }
        else if ('Registration failed' == $status) {
            $_SESSION['message'] = "Registration failed.";
        }
        header("Location: index.php");
    }  
}
function previousValue($item) {
    if (isset($_POST[$item])) {
        return htmlentities(trim($_POST[$item]));
    }
    else {
        return "";
    }
}
require('layout/header.php');
?>

<body onload="showButton('.submit-button')" data-spy="scroll" data-target=".navbar" data-offset="50">
    <nav class="navbar navbar-inverse" data-spy="affix" >
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" 
                data-target="#myNavbar"> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
            </button>
            <a class="navbar-brand" href="index.php">EMS</a> 
            <a class="navbar-brand" href="index.php">Back</a>
        </div>
        <div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="#section1">Basic Information</a></li>
                    <li><a href="#section2">Residence Details</a></li>
                    <li><a href="#section3">Office Details</a></li>
                    <li><a href="#section4">Other Details</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<form name="form" id="form" class="form" enctype="multipart/form-data" action="register.php" 
method="post">
<div id="section1" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 message">
                <?php
                        // creating a div to show errors
                if (isset($errors)) {
                    echo '<div id="message" class="jumbotron visible-div"><br>';
                    foreach($errors as $e => $e_value) {
                        echo '<label class="my-label">' . $e_value . '</label><br>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div><br>
    <div id="progress" class="progress hidden-div">
        <div class="progress-bar progress-bar-striped active" role="progressbar"
        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
        Processing please wait
    </div>
</div>
<h1>Basic Information</h1>
<div class="row">
    <div class="col-md-3">
        <label class="my-label">Profile photo:</label>
        <img id="profilePhoto" src="images/<?php if (isset($record['photo'])) { 
            echo $record['photo']; } else { echo 'userTile.png'; }?>" 
            class="img-responsive" alt="Profile photo"><br>

            <input name="photo" id="uploadBtn" type="file" 
            accept="image/x-png, image/gif, image/jpeg" onchange="readURL(this);"><br>
        </div>

        <div class="col-md-9">
            <div class="row"> <!-- Row starts -->
                <div class="col-sm-4">
                    <label class="my-label">Username:</label>
                    <div class="form-group">
                        <input name="userName" type="text" class="form-control unique" 
                        id="userName" value="<?php echo previousValue('userName'); ?>">
                    </div>
                    <div id="userNameProgress" class="progress hidden-div">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" 
                        style="width:100%">
                        Checking
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label class="my-label">Password:</label>
                <div class="form-group">
                    <input name="password" type="password" class="form-control required" 
                    id="password" value="<?php echo previousValue('password'); ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <label class="my-label">Re-enter Password:</label>
                <div class="form-group">
                    <input name="reEnterPassword" type="password" 
                    class="form-control required" id="reEnterPassword" 
                    value="<?php echo previousValue('reEnterPassword'); ?>">
                </div>
            </div>
        </div> <!-- Row ends -->

        <label class="my-label">Name:</label>
        <div class="row"> <!-- Row starts -->
            <div class="col-sm-4">
                <div class="form-group">
                    <input name="firstName" type="text" class="form-control required" 
                    id="firstName" placeholder="First name" 
                    value="<?php echo previousValue('firstName'); ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input name="middleName" type="text" class="form-control" id="middleName" 
                    placeholder="Middle name" value="<?php echo previousValue('middleName'); ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input name="lastName" type="text" class="form-control required" id="lastName" 
                    placeholder="Last name" value="<?php echo previousValue('lastName'); ?>">
                </div>
            </div>
        </div> <!-- Row ends -->

        <div class="row"> <!-- Row starts -->
            <div class="col-md-4">
                <label class="my-label">Suffix:</label>
                <select name="suffix" class="form-control" id="suffix">
                    <option <?php if(isset($record['suffix']) && $record['suffix'] == "M.Tech") 
                    { echo "selected";} ?> >M.Tech</option>
                    <option <?php if(isset($record['suffix']) && $record['suffix'] == "B.Tech") 
                    { echo "selected";} ?> >B.Tech</option>
                    <option <?php if(isset($record['suffix']) && $record['suffix'] == "M.B.A") 
                    { echo "selected";} ?> >M.B.A</option>
                    <option <?php if(isset($record['suffix']) && $record['suffix'] == "B.B.A") 
                    { echo "selected";} ?> >B.B.A</option>
                    <option <?php if(isset($record['suffix']) && $record['suffix'] == "M.C.A") 
                    { echo "selected";} ?> >M.C.A</option>
                    <option <?php if(isset($record['suffix']) && $record['suffix'] == "B.C.A") 
                    { echo "selected";} ?> >B.C.A</option>
                    <option <?php if(isset($record['suffix']) && $record['suffix'] == "Ph.D") 
                    { echo "selected";} ?> >Ph.D</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="my-label">Date of Birth:</label>
                    <div class="form-group">
                        <input name="dateOfBirth" type="date" class="form-control required" 
                        id="dateOfBirth" placeholder="mm/dd/yyyy" 
                        value="<?php echo previousValue('dateOfBirth'); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="my-label">maritalStatus status:</label>
                <select name="maritalStatus" class="form-control" id="maritalStatus">
                    <option <?php if(isset($record['maritalStatus']) && 
                    $record['maritalStatus'] == "Single") {echo "selected";} ?> >Single</option>
                    <option <?php if(isset($record['maritalStatus']) && 
                    $record['maritalStatus'] == "Married") {echo "selected";} ?> >Married</option>
                    <option <?php if(isset($record['maritalStatus']) && 
                    $record['maritalStatus'] == "Separated") {echo "selected";} ?> >Separated</option>
                    <option <?php if(isset($record['maritalStatus']) && 
                    $record['maritalStatus'] == "Divorced") {echo "selected";} ?> >Divorced</option>
                    <option <?php if(isset($record['maritalStatus']) && 
                    $record['maritalStatus'] == "Widowed") {echo "selected";} ?> >Widowed</option>
                </select>
            </div>
        </div> <!-- Row ends -->

        <div class="row"> <!-- Row starts -->
            <div class="col-md-4">
                <div class="form-group">
                    <label class="my-label">employmentStatus:</label>
                    <select name="employmentStatus" class="form-control" id="employmentStatus">
                        <option <?php if(isset($record['employmentStatus']) && 
                        $record['employmentStatus'] == "Student") {echo "selected";} ?> >
                        Student</option>
                        <option <?php if(isset($record['employmentStatus']) && 
                        $record['employmentStatus'] == "Self-employed") {echo "selected";} ?> >
                        Self-employed</option>
                        <option <?php if(isset($record['employmentStatus']) && 
                        $record['employmentStatus'] == "Unemployed") {echo "selected";} ?> >
                        Unemployed</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label class="my-label">Employer:</label>
                <div class="form-group">
                    <input name="employer" type="text" class="form-control required" id="employer" 
                    value="<?php echo previousValue('employer'); ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <label class="my-label">Email:</label>
                <div class="form-group">
                    <input name="email" type="text" class="form-control unique" id="email" 
                    placeholder="someone@example.com" value="<?php echo previousValue('email'); ?>">
                </div>
                <div id="emailProgress" class="progress hidden-div">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                    Checking
                </div>
            </div>
        </div>
    </div> <!-- Row ends -->

    <div class="row"> <!-- Row starts -->
        <div class="col-md-12">
            <div class="radio">
                <label id="genderLabel">Gender:</label>&nbsp;&nbsp;
                <label><input id="male" type="radio" name="gender" value="1" 
                    <?php if(isset($record['gender']) && $record['gender'] == "1") 
                    { echo "checked";} ?> >Male</label>&nbsp;&nbsp;
                    <label><input id="female" type="radio" name="gender" value="2" 
                        <?php if(isset($record['gender']) && $record['gender'] == "2") 
                        { echo "checked";} ?> >Female</label>
                    </div>
                </div>
            </div> <!-- Row ends -->

        </div>
    </div>
</div>

<div id="section2" class="container-fluid">
    <h1>Residence Details</h1>
    <div class="row"> <!-- Create labels -->
        <div class="col-md-12">
            <label class="my-label">Address:</label>
        </div>
    </div>
    <div class="row"> <!-- Row starts -->
        <div class="col-sm-3">
            <div class="form-group">
                <input name="street" type="text" class="form-control required" id="street" 
                placeholder="Street" value="<?php echo previousValue('street'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="city" type="text" class="form-control required" id="city" 
                placeholder="City" value="<?php echo previousValue('city'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="state" type="text" class="form-control required" id="state" 
                placeholder="State" value="<?php echo previousValue('state'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="zip" type="text" class="form-control required" id="zip" 
                placeholder="Zip" value="<?php echo previousValue('zip'); ?>">
            </div>
        </div>
    </div> <!-- Row ends -->

    <div class="row"> <!-- Create labels -->
        <div class="col-md-8">
            <label class="my-label">Contact:</label>
        </div>
    </div>
    <div class="row"> <!-- Row starts -->
        <div class="col-sm-3">
            <div class="form-group">
                <input name="telephone" type="text" class="form-control required" id="telephone" 
                placeholder="Telephone" value="<?php echo previousValue('telephone'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="mobile" type="text" class="form-control required" id="mobile" 
                placeholder="Mobile" value="<?php echo previousValue('mobile'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="fax" type="text" class="form-control" id="fax" placeholder="Fax" 
                value="<?php echo previousValue('fax'); ?>">
            </div>
        </div>
    </div> <!-- Row ends -->
</div>
<div id="section3" class="container-fluid">
    <h1>Office Details</h1>
    <div class="row"> <!-- Create labels -->
        <div class="col-md-12">
            <label class="my-label">Address:</label>
        </div>
    </div>
    <div class="row"> <!-- Row starts -->
        <div class="col-sm-3">
            <div class="form-group">
                <input name="officeStreet" type="text" class="form-control" id="officeStreet" 
                placeholder="Street" value="<?php echo previousValue('officeStreet'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="officeCity" type="text" class="form-control" id="officeCity" 
                placeholder="City" value="<?php echo previousValue('officeCity'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="officeState" type="text" class="form-control" id="officeState" 
                placeholder="State" value="<?php echo previousValue('officeState'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="officeZip" type="text" class="form-control" id="officeZip" 
                placeholder="Zip" value="<?php echo previousValue('officeZip'); ?>">
            </div>
        </div>
    </div> <!-- Row ends -->

    <div class="row"> <!-- Create labels -->
        <div class="col-md-8">
            <label class="my-label">Contact:</label>
        </div>
    </div>
    <div class="row"> <!-- Row starts -->
        <div class="col-sm-3">
            <div class="form-group">
                <input name="officeTelephone" type="text" class="form-control" id="officeTelephone" 
                placeholder="Telephone" value="<?php echo previousValue('officeTelephone'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="officeMobile" type="text" class="form-control" id="officeMobile" 
                placeholder="Mobile" value="<?php echo previousValue('officeMobile'); ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <input name="officeFax" type="text" class="form-control" id="officeFax" 
                placeholder="Fax" value="<?php echo previousValue('officeFax'); ?>">
            </div>
        </div>
    </div> <!-- Row ends -->
</div>
<div id="section4" class="container-fluid">
    <h1>Other Details</h1>
    <div class="row"> <!-- Create labels -->
        <div class="col-md-8">
            <label class="my-label">Prefered mode of communication:</label>
        </div>
    </div>
    <div class="row"> <!-- Row starts -->
        <div class="col-sm-3">
            <div class="checkbox">
                <label><input name="optionEmail" type="checkbox" value="1" 
                    <?php if(isset($record['optionEmail']) && $record['optionEmail'] == "1") 
                    { echo "checked";} ?> >Email</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="checkbox">
                    <label><input name="optionMessage" type="checkbox" value="1" 
                        <?php if(isset($record['optionMessage']) && 
                        $record['optionMessage'] == "1") {echo "checked";} ?> >Message</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="checkbox">
                        <label><input name="optionPhone" type="checkbox" value="1" 
                            <?php if(isset($record['optionPhone']) && 
                            $record['optionPhone'] == "1") {echo "checked";} ?> >
                            Phone call</label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label><input name="optionAny" type="checkbox" value="1" 
                                <?php if(isset($record['optionAny']) && 
                                $record['optionAny'] == "1") {echo "checked";} ?> >Any</label>
                            </div>
                        </div>
                    </div> <!-- Row ends -->
                    <div class="row"> <!-- Create input fields -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="my-label">More about you:</label>
                                <textarea name="moreAboutYou" class="form-control" rows="5" 
                                id="moreAboutYou">
                                <?php echo trim(stripslashes(previousValue('moreAboutYou'))); ?>
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div id="section5" class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <input name="submit" type="submit" class="btn btn-default 
                        submit-button" value="submit">
                    </div>
                </div>
            </div>
        </form>
    </body>
    <?php require_once('layout/footer.php'); ?>