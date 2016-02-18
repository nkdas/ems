<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['pk_admin'])) {
    header('Location: index.php');
}
require(dirname(__DIR__)).'/layout/header.php';
?>
<body onload="displayMap()">
    <nav class="navbar navbar-inverse" data-spy="affix">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" 
                data-target="#homeNavbar">
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                </button>
                <a class="navbar-brand" href="admin_home.php">Admin</a> 
            </div>
            <div>
                <div class="collapse navbar-collapse" id="homeNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Map</a></li>
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
                <div id="googleMap"></div>
            </div>
        </div>
    </div>
</body>
<?php require(dirname(__DIR__)).'/layout/footer.php';?>