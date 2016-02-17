<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');
if (!isset($_SESSION['pk_admin'])) {
    header("Location: index.php");
}
else {
    $query = mysqli_query($connection, "SELECT firstName, twitterId
        FROM employee_details");
    $record = array();
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($record, $row['firstName'] . ' ' . $row['twitterId']);
        }
    }

    require((dirname(__DIR__)) . '/layout/header.php');
}
?>
<body onload="viewTwitter();">
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
                        <li><a href="#">Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="sectionAdmin" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3>Select a user to view his/her tweets</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php
                echo '<select id="userList" name="userList" onchange="viewTwitter()" class="form-control">';
                foreach ($record as $key => $value) {
                    $data = explode(" ", $value);
                    echo '<option value="' . $data[1] . '">' . $data[0] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div id="twitterDiv" class="col-md-4">

            </div>
        </div>
    </div>
</body>
<?php require((dirname(__DIR__)) . '/layout/footer.php');?>
