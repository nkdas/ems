<?php
/**
* This page serves as the index/login page for the application
* @author Neeraj Kumar Das <neeraj.das@mindfiresolutions.com>
*/

// Turn on error reporting
ini_set('display_errors','On');
error_reporting(E_ALL);

// start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Store messages from session (if any) to $message
$message='';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

// if a user is already logged in then redirect to home page
if (isset($_SESSION['id'])) {
    header("Location: home.php");
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
    <section id="section1" class="container-fluid">
        <div class="row">
            <div class="col-md-offset-1 col-md-6">
                <h1 id="mainHeading">EMS</h1>
                <h3>Employee Management System</h3>
                <label class="my-label">Sign up to get the most out of it!</label>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 message">
                        <?php
                        // creating a div to show messages
                        if ($message) {
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

                <form class="form" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="loginForm" class="jumbotron">
                                <div class="form-group">
                                    <label class="my-label">Username</label>
                                    <input name="userName" type="text" class="form-control" 
                                    id="userName" value="<?php echo previousValue('userName'); ?>">
                                    <br>
                                    <label class="my-label">Password</label>
                                    <input name="password" type="password" class="form-control" 
                                    id="password" value="<?php echo previousValue('password'); ?>">
                                    <br>
                                    <input name="signin" id="signin" type="button" 
                                    class="btn btn-primary" value="Sign in"><br>
                                </div>
                                <label class="my-label"><a href="forgot_password.php">
                                Forgot password? Click here!</a></label><br>
                                <label class="my-label"><a href="register.php">
                                New user? Sign up here!</a></label>
                                <div id="progress" class="progress hidden-div">
                                    <div class="progress-bar progress-bar-striped active" 
                                    role="progressbar" aria-valuenow="100" aria-valuemin="0" 
                                    aria-valuemax="100">
                                        Checking
                                    </div>
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