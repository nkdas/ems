<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');

// recieve ajax post
$addObject = new Add;
if (isset($_POST['role'])) {
    $status = $addObject->add('roles', 'role', $_POST['role']);
    echo $status;
}
else if (isset($_POST['resource'])) {
    $status = $addObject->add('resources', 'resource', $_POST['resource']);
    echo $status;
}

class Add {
    public function add($table, $column, $columnValue) {
        global $connection;
        $sql = "INSERT INTO $table ($column) VALUES ('$columnValue')";
        if (mysqli_query($connection, $sql)) {
            $status = 'success';
        }
        else {
            $status = $query;
        }
        return $status;
    }
}
?>