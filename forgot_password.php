<?php
/**
* This page helps the user in changing the password
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
require('mail.php');

// if the user is already signed in then redirect to home page
if (isset($_SESSION['id'])) {
    header("Location: home.php");
}
else
{
    // check if the user has submitted the form
    if (isset($_POST['submit'])) {

        // check if the user has entered all the employee_details
        if (!$_POST['userName']) {
            $message = "Please enter your userName<br>";
        }
        if (!$_POST['email']) {
            $message = $message . "Please enter your email";
        }
        if (!isset($message)) {
            // fetch userName and email from $_POST
            $userName = mysqli_real_escape_string($connection, trim($_POST['userName']));
            $email = mysqli_real_escape_string($connection, trim($_POST['email']));
            
            // fetch activation key, id, firstName of the user from the database
            $query = mysqli_query($connection, "SELECT activationKey, id, firstName 
                                                FROM employee_details 
                                                WHERE userName = '$userName' AND email = '$email'");
            if ($query && ($row = mysqli_fetch_assoc($query))) {
                    $key = $row['activationKey'];
                   
                $_SESSION['id'] = $row['id'];

                $mailTo = $email;
                $mailSubject = "Password Recovery";
                $mailBody = "Hi " . $row['firstName'] . 
                "!<br>Follow the link to change your password.<br>
                <a href='http://localhost/ems/change_password.php?key=$key'>Change your password</a>";
                   
                $status = sendMail($mailTo, $mailSubject, $mailBody);
                if ('success' == $status) {
                    $_SESSION['message'] = "Please check your email and follow the link to change your password.";
                }
                else if ('failed' == $status) {
                    $_SESSION['message'] = "Unable to send mail.";
                }
                header("Location: index.php");
            }
            // if fetch from the database is unsuccessful
            else
            {
                $message = "Either userName or Email is Invalid! ";
            }
        }
    }
}
if (isset($_POST['cancel'])) {
    header("Location: index.php");
}

function previousValue($item) {
    if (isset($_POST[$item])) {
        return $_POST[$item];
    }
    else {
        return "";
    }
}

require('layout/header.php');
?>

    <body>
        <section id="section1" class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 id="mainHeader">EMS</h1>
                    <h3>Password Recovery</h3>
                    <label class="my-label">Forgot your password? 
                            Don't worry we are there to help.<br>
                            Just enter your userName and email.
                    </label>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            // creating a div to show messages
                                if (isset($message)) {
                                    echo '<div id="message" class="jumbotron visible-div">';
                                    echo '<label class="my-label">'.$message.'</label></div>';
                                    if (!isset($_SESSION['id'])) {
                                        session_unset();
                                        session_destroy();
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <form class="form" method="post" action="forgot_password.php">
                        <div class="row">
                            <div class="col-md-12"> 
                                <div id="loginForm" class="jumbotron">
                                    <div class="form-group">
                                        <label class="my-label">Username</label>
                                        <input name="userName" type="text" class="form-control" id="userName" 
                                        placeholder="userName" value="<?php echo previousValue('userName'); ?>"><br>
                                        <label class="my-label">Email</label>
                                        <input name="email" type="text" class="form-control" id="email" 
                                        placeholder="someone@example.com" value="<?php echo previousValue('email'); ?>"><br>
                                        <input name="submit" type="submit" class="btn btn-primary" value="Submit">
                                        <input name="cancel" type="submit" class="btn btn-primary" value="Cancel">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </body>
<?php require('layout/footer.php'); ?>