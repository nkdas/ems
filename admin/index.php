<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');

ini_set('display_errors','On');
error_reporting(E_ALL);

if(isset($_SESSION['pk_admin'])) {
    header("Location: admin_home.php");
}

require((dirname(__DIR__)) . '/layout/header.php');?>
<body>
    <div id="section1" class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <h1>Admin</h1>
                <form class="form" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="loginForm" class="jumbotron">
                                <div class="form-group">
                                    <label class="my-label">Username</label>
                                    <input name="userName" type="text" class="form-control" id="userName" 
                                    value="<?php if (isset($_POST['userName'])) { echo $_POST['userName']; } ?>"><br>
                                    <label class="my-label">Password</label>
                                    <input name="password" type="password" class="form-control" id="password" 
                                    value="<?php if (isset($_POST['password'])) { echo $_POST['password']; } ?>"><br>
                                    <input name="signin" id="signin" type="button" class="btn btn-primary admin-button" value="Sign in"><br>
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
<?php require((dirname(__DIR__)) . '/layout/footer.php');?>