<?php
// Turn on error reporting
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'resources/db_connection.php';
require 'acl.php';

if (isset($_SESSION['id'])) {
    $acl = new acl();
    $privilege = $acl->checkPrivilege($_SESSION['id'], 5);
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
                    <?php //echo htmlentities($name); ?>
                </a> 
            </div>
            <div>
                <div class="collapse navbar-collapse" id="homeNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="edit.php">Edit profile</a></li>
                        <li><a href="change_password.php">Change password</a></li>
                        <li><a href="logout.php">Sign out</a></li>
                        <li><a href="#">Assignment</a></li>
                        <li><a href="notice.php">Notice</a></li>
                        <li><a href="events.php">Events</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="sectionAdmin" class="container-fluid">
        <h2>Assignment</h2>
        <ul class="nav nav-tabs">
            <?php
            if (in_array(1, $privilege) || in_array(5, $privilege)) {
                echo '<li><a data-toggle="tab" href="#add">Add</a></li>';
            }
            if (in_array(2, $privilege) || in_array(5, $privilege)) {
                echo '<li><a data-toggle="tab" href="#delete">Delete</a></li>';
            }
            if (in_array(3, $privilege) || in_array(5, $privilege)) {
                echo '<li><a data-toggle="tab" href="#view">View</a></li>';
            }
            if (in_array(4, $privilege) || in_array(5, $privilege)) {
                echo '<li><a data-toggle="tab" href="#edit">Edit</a></li>';
            }
            ?>
        </ul>
        <?php
        if (empty($privilege)) {
            echo '<h2>Sorry You are not authorized to access this page </h2>';
        }
        ?>
        <div class="tab-content">
            <?php if (in_array(1, $privilege) || in_array(5, $privilege)) { ?>
            <div id="add" class="tab-pane fade">
                <h3>Add</h3>
            </div>
            <?php } ?>

            <?php if (in_array(2, $privilege) || in_array(5, $privilege)) { ?>
            <div id="delete" class="tab-pane fade">
                <h3>Delete</h3>
            </div>
            <?php } ?>

            <?php if (in_array(3, $privilege) || in_array(5, $privilege)) { ?>
            <div id="view" class="tab-pane fade">
                <h3>View</h3>
            </div>
            <?php } ?>
            
            <?php if (in_array(4, $privilege) || in_array(5, $privilege)) { ?>
            <div id="edit" class="tab-pane fade">
                <h3>Edit</h3>
            </div>
            <?php } ?>
        </div>        
    </div>
</body>
<?php require 'layout/footer.php';
