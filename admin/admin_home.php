<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');
require((dirname(__DIR__)) . '/db_functions.php');
require((dirname(__DIR__)) . '/process_data.php');

if (!isset($_SESSION['pk_admin'])) {
    header("Location: index.php");
}
else {

    if (isset($_POST['submit'])) {
    $userId = $_POST['id'];
    $_SESSION['userName'] = $_POST['userName'];
    
    $processData = new ProcessData;
    $record = $processData->setData($_POST, $_FILES);
    $row = $record;
    
    // validate $row
    $errors = $processData->validateData($row, "update");
   
    // if no error exists after validation then update the employee_details of the user
    if (!$errors) { 
        $status = update_record($userId, $connection, $row);      
        if(1 == $status) {
            $_SESSION['message'] = "Your changes have been saved successfully";
            header("Location: admin_home.php");
        }
        else {
            $_SESSION['message'] = "Sorry! Unable to save your changes";
            header("Location: admin_home.php");
        }
    }
}

}
require((dirname(__DIR__)) . '/layout/header.php');
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
                <a class="navbar-brand" href="#">Admin</a> 
            </div>
            <div>
                <div class="collapse navbar-collapse" id="homeNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="map.php">Map</a></li>
                        <li><a href="privilege.php">Settings</a></li>
                        <li><a href="logout.php">Sign out</a></li>
                        <li><a href="twitter.php">Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="section1" class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <!-- Modal -->
                <div id="myModal" class="modal fade container-fluid" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;
                                </button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="employee" class="display table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Lastname</th>
                                <th>Role</th>
                                <th>Suffix</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Marital Status</th>
                                <th>Employement Status</th>
                                <th>Employer</th>
                                <th>Email</th>
                                <th>Street</th>
                                <th>City</th>
                                <th>State</th>
                                <th>ZIP</th>
                                <th>Telephone</th>
                                <th>Mobile</th>
                                <th>Fax</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php require((dirname(__DIR__)) . '/layout/footer.php');?>