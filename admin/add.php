<?php

require_once(dirname(__DIR__)).'/resources/db_connection.php';

if (isset($_SESSION['pk_admin'])) {
    // recieve ajax post
    $addObject = new Add();
    if (isset($_POST['role'])) {
        $status = $addObject->add('roles', 'role', $_POST['role']);
        echo $status;
    } elseif (isset($_POST['resource'])) {
        $status = $addObject->add('resources', 'resource', $_POST['resource']);
        echo $status;
    }
} else {
    header('Location: index.php');
}

class add
{
    public function add($table, $column, $columnValue)
    {
        global $connection;
        $sql = "INSERT INTO $table ($column) VALUES ('$columnValue')";
        if (mysqli_query($connection, $sql)) {
            $status = 'success';
        } else {
            $status = 'failed';
        }

        return $status;
    }
}
