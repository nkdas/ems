<?php
/**
* This page helps the user in changing the password
* @author Neeraj Kumar Das <neeraj.das@mindfiresolutions.com>
*/

// Turn on error reporting
ini_set('display_errors','On');
error_reporting(E_ALL);

require_once('resources/db_connection.php');

// get key from the url
// if the url has a 'key', it means user has forgotten the password and wants to change it
try {
    if (isset($_GET['key'])) {
        $key = $_GET['key'];
        if(!isset($_SESSION['key'])) {
            $_SESSION['key'] = $key;
        }
    }
}
catch (Exception $ex) {}

if (isset($_SESSION['id']) || isset($_SESSION['key'])) {

    // if the session doesn't have a 'key', it means user has not forgotten the password and 
    // wants to change it
    if(!isset($_SESSION['key'])) {
        $userId = $_SESSION['id'];
        $name = $_SESSION['name'];
    }

    // check if the user has submitted the form
    if (isset($_POST['submit'])) {
        // fetch employee_details from $_POST
        if (!isset($_SESSION['key'])) {
            $password = mysqli_real_escape_string($connection, trim($_POST['password']));
        }
        $newPassword = mysqli_real_escape_string($connection, trim($_POST['newPassword']));
        $reEnterNewPassword = mysqli_real_escape_string($connection, 
        trim($_POST['reEnterNewPassword']));

        // array to store the errors
        $errors = array();
        //i serves as the key or index to the array errors.
        $i = 1;

        // check if the new password meets length requirements
        if (strlen($newPassword) < 6) {
            $errors[$i] = "Passwords must be of at least 6 characters";
            $i++;
        } 
        // check if new password and repeat new password fields contain the same value
        if ($newPassword != $reEnterNewPassword) {
            $errors[$i] = "Passwords entered in the 'Password' and 'Re-enter Password' 
            fields donot match";
            $i++;
        }

        // backup passwords to be used if the user has made errors and the password fields 
        // need to be repopulated
        if (!isset($_SESSION['key'])) {
            $passwordBackup = $password;
            $password = md5($password);
        }
        $newPasswordBackup = $newPassword;
        $reEnterNewPasswordBackup = $reEnterNewPassword;

        $newPassword = md5($newPassword);
        $reEnterNewPassword = md5($reEnterNewPassword);

        if (!isset($_SESSION['key'])) {

            // fetch old password from the database
            $query = mysqli_query($connection, "SELECT password
                                                FROM employee_details 
                                                WHERE id = '$userId'");
            if ($query and $row = mysqli_fetch_assoc($query)) {
                $opassword = $row['password'];

                // check if the password matches with the old password
                if ($password != $opassword) {
                    $errors[$i] = "The old password you entered is invalid";
                    $i++;
                }
            }
        }

        // if no errors exists then update the new password and redirect to users home page
        if (!$errors) { 
            if(!isset($_SESSION['key'])) {
                $query = mysqli_query($connection, "UPDATE employee_details 
                                                    SET password = '$newPassword'
                                                    WHERE id = $userId");
                if($query) {
                    $_SESSION['message'] = "Your password was changed successfully";
                    header("Location: home.php");
                }
                else {
                    $_SESSION['message'] = "Unable to change your password!<br>Please try again.";
                    header("Location: index.php");
                }
            }
            else {
                $activationKey = $_SESSION['key'];
                $query = mysqli_query($connection, "UPDATE employee_details 
                                                    SET password = '$newPassword'
                                                    WHERE activationKey = '$activationKey'");
                if($query) {
                    $_SESSION['message'] = "Your password was changed successfully";
                    header("Location: index.php");
                }
                else {
                    $_SESSION['message'] = "Unable to change your password!<br>Please try again.";
                    header("Location: index.php");
                }
            }
        }
    }

    if (isset($_POST['cancel'])) {
        if(!isset($_SESSION['key'])) {
            header("Location: home.php");
        }
        else {
            header("Location: index.php");
        }
    }
}
else
{
    header("Location: index.php");
}

function previousValue($item) {
    if (isset($_POST[$item])) {
        return htmlentities($_POST[$item]);
    }
    else {
        return "";
    }
}

require('layout/header.php');
?>
    <body>
        <?php if (!isset($_SESSION['key'])) { ?>
        <nav class="navbar navbar-inverse" data-spy="affix">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" 
                    data-target="#homeNavbar">
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                    </button>
                    <a class="navbar-brand" href="home.php">
                        <?php if (!isset($_SESSION['key'])) { echo htmlentities($name); } ?>
                    </a> 
                </div>
                <div>
                    <div class="collapse navbar-collapse" id="homeNavbar">
                        <ul class="nav navbar-nav">
                            <li><a href="home.php">Back</a></li>
                            <li><a href="edit.php">Edit profile</a></li>
                            <li><a href="logout.php">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <?php } ?>
        <section id="section1" class="container-fluid">
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-6">
                    <h1 id="mainHeader">EMS</h1>
                    <h3>Change password</h3>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if (isset($errors)) {
                                echo '<div id="message" class="jumbotron visible-div">';
                                foreach($errors as $e => $e_value) {
                                    echo '<label class="my-label">' . $e_value . '</label><br>';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div> <!-- end of message div -->

                    <form class="form" method="post" action="change_password.php">
                        <div class="row">
                            <div class="col-md-12"> 
                                <div id="loginForm" class="jumbotron">
                                    <div class="form-group">
                                        <?php if (!isset($_SESSION['key'])) { ?>
                                        <label class="my-label">Old Password</label>
                                        <input name="password" type="password" class="form-control" 
                                        id="password" ><br>
                                        <?php } ?>
                                        <label class="my-label">New Password</label>
                                        <input name="newPassword" type="password" 
                                        class="form-control" 
                                        id="newPassword" ><br>
                                        <label class="my-label">Re-enter New Password</label>
                                        <input name="reEnterNewPassword" type="password" 
                                        class="form-control" 
                                        id="reEnterNewPassword" >
                                        <br>
                                        <input name="submit" type="submit" 
                                        class="btn btn-primary" value="Change Password">
                                        <input name="cancel" type="submit" 
                                        class="btn btn-primary" value="Cancel">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-1">
                </div>
            </div>
        </section>
    </body>
<?php require('layout/footer.php'); ?>