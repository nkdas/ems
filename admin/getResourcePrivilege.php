<?php

require_once(dirname(__DIR__)).'/resources/db_connection.php';
require(dirname(__DIR__)).'/db_functions.php';

function getId($element, $elementValue, $tableName)
{
    global $connection;
    $query = mysqli_query($connection, "SELECT id 
        FROM $tableName
        WHERE $element = '$elementValue'");
    if ($query and $row = mysqli_fetch_assoc($query)) {
        return $row['id'];
    }
}

function isMarked($resource, $privilege, $resourcePrivileges)
{
    $flag = false;
    for ($i = 0; $i < count($resourcePrivileges); ++$i) {
        if (($resource == $resourcePrivileges[$i]['resource_id']) &&
            ($privilege == $resourcePrivileges[$i]['privilege_id'])) {
            $flag = true;
            break;
        } else {
            $flag = false;
        }
    }

    return $flag;
}

if (isset($_SESSION['pk_admin'])) {
    $roles = getRoles($connection);
    $resources = getResources($connection);
    $privileges = getPrivileges($connection);

    if (isset($_POST['role'])) {
        $roleId = getId('role', $_POST['role'], 'roles');
        $resourcePrivileges = getResourcePrivileges($connection, $roleId);
    } else {
        $resourcePrivileges = getResourcePrivileges($connection, 1);
    }

    // draw a table for the page
    $content = '<thead><tr><th></th>';

    // draw table header (row 1)
    foreach ($privileges as $key => $value) {
        $content = $content.'<th>'.$value['privilege'].'</th>';
    }
    $content = $content.'</tr></thead>';

    // draw table content
    foreach ($resources as $key => $resourceValue) {
        // add resources to column 1
        $content = $content.'<tr><td>'.$resourceValue['resource'].'</td>';

        foreach ($privileges as $key => $privilegeValue) {
            if (isMarked($resourceValue['id'], $privilegeValue['id'], $resourcePrivileges)) {
                $attribute = 'checked';
            } else {
                $attribute = '';
            }

            $content = $content.'<td><input class="myCheckBox" type="checkbox" 
            name="'.$resourceValue['resource'].'_'.$privilegeValue['privilege'].'" 
            value="'.$resourceValue['id'].'_'.$privilegeValue['id'].'"'.
            $attribute.'></td>';
        }
        $content = $content.'</tr>';
    }

    // return drawn html to calling function [getResourcePrivilege() in admin.js]
    echo $content;
} else {
    header('Location: index.php');
}
