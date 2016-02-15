<?php
/**
* This page serves as the home page for the user.
*
* @author Neeraj Kumar Das <neeraj.das@mindfiresolutions.com>
*/

// Turn on error reporting
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'resources/db_connection.php';

// this variable acts as a flag to determine if user employee_details are retrieved successfully 
// from the database and weather to show the home page or not
$pass = 0;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $_SESSION['message'] = null;
}

// check if user is signed in
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // fetch user details from the database
    $query = mysqli_query(
        $connection,
        "SELECT userName, password, firstName, middleName, 
        lastName, suffix, gender, dateOfBirth, maritalStatus, employmentStatus, employer, email, 
        street, city, state, zip, telephone, mobile, fax, officeStreet, officeCity, officeState,
        officeZip, officeTelephone, officeMobile, officeFax, optionEmail, optionMessage, 
        optionPhone, optionAny, moreAboutYou, photo
        FROM employee_details
        WHERE id = $userId"
    );
    if ($query and $row = mysqli_fetch_assoc($query)) {
        $pass = 1;
        $name = $row['firstName'].' '.$row['middleName'].' '.$row['lastName'];
        $_SESSION['name'] = $name;
    }
} else {
    header('Location: index.php');
}
require 'layout/header.php';
?>

<body>
    <nav class="navbar navbar-inverse" data-spy="affix">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" 
                data-target="#homeNavbar">
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                </button>
                <a class="navbar-brand" href="#">
                    <?php echo htmlentities($name); ?>
                </a> 
            </div>
            <div>
                <div class="collapse navbar-collapse" id="homeNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="edit.php">Edit profile</a></li>
                        <li><a href="change_password.php">Change password</a></li>
                        <li><a href="logout.php">Sign out</a></li>
                        <li><a href="assignments.php">Assignment</a></li>
                        <li><a href="notice.php">Notice</a></li>
                        <li><a href="events.php">Events</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="section1" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
<?php
// creating a div to show messages
if (isset($message)) {
    echo '<div id="message" class="jumbotron visible-div">';
    echo '<label class="my-label">'.$message.'</label></div>';
    if (!$_SESSION['id']) {
        session_unset();
        session_destroy();
    }
}
?>
            </div>
        </div> <!-- row ends -->

        <div class="row">
            <div class="col-md-2">
                <img id="profilePhoto" src="images/<?php if ($row['photo']) {
    echo $row['photo'];
} else {
    echo 'userTile.png';
}?>" class="img-responsive" alt="Profile photo"><br>
            </div>
            <div class="col-md-10">
                <div id="homeBgDiv">
                    <div class="row">
                        <div class="col-md-6">    
                            <h3 id="homeHeading" class="homeHeading">Basic information</h3>
                            <div class="row"> <!-- Name -->
                                <div class="col-sm-4">
                                    <label class="my-label">Name:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
<?php
echo htmlentities($row['firstName']).' '.
htmlentities($row['middleName']).' '.
htmlentities($row['lastName']);
?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Suffix -->
                                <div class="col-sm-4">
                                    <label class="my-label">Suffix:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['suffix']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Gender -->
                                <div class="col-sm-4">
                                    <label class="my-label">Gender:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
<?php
if ($row['gender'] == '1') {
    echo 'Male';
} else {
    echo 'Female';
}?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- dateOfBirth -->
                                <div class="col-sm-4">
                                    <label class="my-label">Date of Birth:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['dateOfBirth']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Marital Status -->
                                <div class="col-sm-4">
                                    <label class="my-label">Marital Status:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo $row['maritalStatus']; ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- employmentStatus -->
                                <div class="col-sm-4">
                                    <label class="my-label">Employment Status:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo $row['employmentStatus']; ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Employer-->
                                <div class="col-sm-4">
                                    <label class="my-label">Employer:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['employer']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Email -->
                                <div class="col-sm-4">
                                    <label class="my-label">Email:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['email']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->
                        </div> <!-- end of column -->
                    </div> <!-- Row ends -->

                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="homeHeading">Residence Details</h3>
                            <div class="row"> <!-- Street -->
                                <div class="col-sm-4">
                                    <label class="my-label">Street:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['street']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- City -->
                                <div class="col-sm-4">
                                    <label class="my-label">City:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['city']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- State -->
                                <div class="col-sm-4">
                                    <label class="my-label">State:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['state']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Zip -->
                                <div class="col-sm-4">
                                    <label class="my-label">Zip:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['zip']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Telephone -->
                                <div class="col-sm-4">
                                    <label class="my-label">Telephone:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['telephone']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Mobile -->
                                <div class="col-sm-4">
                                    <label class="my-label">Mobile:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['mobile']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Fax -->
                                <div class="col-sm-4">
                                    <label class="my-label">Fax:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['fax']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->
                        </div> <!-- end of column -->

                        <div class="col-md-6">
                            <h3 class="homeHeading">Office Details</h3>
                            <div class="row"> <!-- Street -->
                                <div class="col-sm-4">
                                    <label class="my-label">Street:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['officeStreet']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- City -->
                                <div class="col-sm-4">
                                    <label class="my-label">City:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['officeCity']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- State -->
                                <div class="col-sm-4">
                                    <label class="my-label">State:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['officeState']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Zip -->
                                <div class="col-sm-4">
                                    <label class="my-label">Zip:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['officeZip']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Telephone -->
                                <div class="col-sm-4">
                                    <label class="my-label">Telephone:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['officeTelephone']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Mobile -->
                                <div class="col-sm-4">
                                    <label class="my-label">Mobile:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['officeMobile']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->

                            <div class="row"> <!-- Fax -->
                                <div class="col-sm-4">
                                    <label class="my-label">Fax:</label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="my-label">
                                        <?php echo htmlentities($row['officeFax']); ?>
                                    </label>
                                </div>
                            </div> <!-- Row ends -->
                        </div> <!-- end of column -->
                    </div> <!-- Row ends -->
                </div> <!-- end of homeBgDiv -->
            </div> <!-- end of column -->
        </div><br> <!-- end of row -->
    </div> <!-- end of section 1 -->
</body>
<?php require_once 'layout/footer.php';
