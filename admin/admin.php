<?php
require_once('db_connection.php');
$userName = mysqli_real_escape_string($connection, trim($_POST['userName']));
$password = mysqli_real_escape_string($connection, trim($_POST['password']));
if(($userName == 'admin') && ($password == 'admin')) {
    header("Location: admin_home.php");
}
require('header.php');
?>
<body>
    <div id="section1" class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <h1>Admin</h1>
                <form class="form" method="post" action="admin.php">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="loginForm" class="jumbotron">
                                <div class="form-group">
                                    <label class="my-label">userName</label>
                                    <input name="userName" type="text" class="form-control" id="userName" value="<?php echo $_POST['userName']; ?>"><br>
                                    <label class="my-label">Password</label>
                                    <input name="password" type="password" class="form-control" id="password" value="<?php echo $_POST['password']; ?>"><br>
                                    <input name="adminsignin" id="adminsignin" type="submit" class="btn btn-primary" value="Sign in"><br>
                                </div>
                                <div id="progress" class="progress hidden-div">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                		Checking
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</body>
<?php require('footer'); ?>