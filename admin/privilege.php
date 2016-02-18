<?php
require_once(dirname(__DIR__)).'/resources/db_connection.php';
require(dirname(__DIR__)).'/db_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['pk_admin'])) {
    header('Location: index.php');
}

require(dirname(__DIR__)).'/layout/header.php';
?>
<body onload="initializeAcl()">
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
                        <li><a href="map.php">Map</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="logout.php">Sign out</a></li>
                        <li><a href="twitter.php">Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="sectionAdmin" class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#roleDiv">Roles</a></li>
            <li><a data-toggle="tab" href="#resourceDiv">Resources</a></li>
            <li><a data-toggle="tab" href="#privilegeDiv">Privileges</a></li>
        </ul>

        <div class="tab-content">
            <div id="roleDiv" class="tab-pane fade in active">
                <h3>Roles</h3>
                <div class="col-md-offset-2 col-md-4">
                    <div class="table-responsive">
                        <table id="roleContent" class="table" cellspacing="0">
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="my-label">Add Role</label>
                    <div class="form-group">
                        <input name="roleBox" type="text" class="form-control" id="roleBox">
                    </div>
                    <input name="roleButton" onclick="addRole()" type="button" 
                    class="btn btn-primary" value="Add">
                </div>
            </div>
            <div id="resourceDiv" class="tab-pane fade">
              <h3>Resources</h3>
              <div class="col-md-offset-2 col-md-4">
                    <div class="table-responsive">
                        <table id="resourceContent" class="table" cellspacing="0">
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="my-label">Add Resource</label>
                    <div class="form-group">
                        <input name="resourceBox" type="text" class="form-control" id="resourceBox">
                    </div>
                    <input name="resourceButton" onclick="addResource()" type="button" 
                    class="btn btn-primary" value="Add">
                </div>
            </div>
            <div id="privilegeDiv" class="tab-pane fade">
                <h3>Privileges</h3>
                <form name="myform" id="myform" method="post">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <label class="my-label">Roles</label>
                            <select id="roleSelect" onchange="getResourcePrivilege()" name="role" 
                            class="form-control" 
                            id="role">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4"><br>
                            <div class="table-responsive">
                                <table id="tableContent" class="table" cellspacing="0">
                                </table>
                            </div><br>
                            <input type="button" id="privilegeButton" name="privilegeButton" 
                            class="btn btn-primary" value="save" onclick="saveData()">
                        </div>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</body>
<?php require(dirname(__DIR__)).'/layout/footer.php';?>