<?php

require_once(dirname(__DIR__)).'/resources/db_connection.php';
if (isset($_SESSION['pk_admin'])) {
    if (isset($_POST['id']) && isset($_POST['element']) && isset($_POST['value'])) {
        $id = $_POST['id'];
        $element = $_POST['element'];
        $value = $_POST['value'];

        $query = "UPDATE employee_details 
        SET $element = '$value'
        WHERE id = $id";
        $sql = mysqli_query($connection, $query);

        if ($sql) {
            $status = array('status' => 'success');
            echo json_encode($status);
        } else {
            $status = array('status' => 'failed');
            echo json_encode($status);
        }
    }
} else {
    header('Location: index.php');
}
