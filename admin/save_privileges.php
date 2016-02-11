<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');
require('privilege.php');

if(isset($_POST['role'])) {
    $role = $_POST['role'];
    $roleId = getId('role', $role, 'roles');
    
    $resourcePrivileges = getResourcePrivileges($connection, $roleId);
    if (isset($resourcePrivileges)) {
        removeResourcePrivilege($connection, $roleId);
    }
 
    foreach ($_POST as $key => $value) {
        if ('role' != $key) {
            $data = explode("_", $value);
            $status = insertPrivilege($roleId, $data[0], $data[1]);
        }
    }
}

function getId($element, $elementValue, $tableName) {
    global $connection;
    $query = mysqli_query($connection, "SELECT id 
        FROM $tableName
        WHERE $element = '$elementValue'");
    if ($query and $row = mysqli_fetch_assoc($query)) {
        return $row['id'];
    }
}

function insertPrivilege($role, $resource, $privilege) {
    global $connection;
    $query= mysqli_query($connection, "INSERT INTO user_resource_privilege 
                (role_id, resource_id, privilege_id)
                VALUES ($role, $resource, $privilege)");
    if ($query) {
        $status = 'success';
    }
    else {
        $status = 'failed';
    }
    return $status;
}
?>