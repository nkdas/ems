<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');
require((dirname(__DIR__)) . '/db_functions.php');

// recieve ajax post
$createObject = new CreateHtml;
if (isset($_POST['item'])) {
    if ('role' == $_POST['item']) {
        $status = $createObject->createRolesHtml();
        echo $status;
    }
    else if ('resource' == $_POST['item']) {
        $status = $createObject->createResourceHtml();
        echo $status;
    }
    else {
        $status = $createObject->createRoleSelectHtml();
        echo $status;
    }
}

class CreateHtml {
    function createRolesHtml() {
        global $connection;
        $roles = getRoles($connection);

        $content = '<thead><tr><th>ID</th><th>ROLE</th></tr></thead>';

        foreach ($roles as $key => $value) {
            $content = $content . 
            '<tr><td>' . $value['id'] . '</td><td>' . $value['role'] . '</td></tr>';
        }
        return $content;
    }

    function createResourceHtml() {
        global $connection;
        $resources = getResources($connection);
        
        $content = '<thead><tr><th>ID</th><th>RESOURCE</th></tr></thead>';

        foreach ($resources as $key => $value) {
            $content = $content . 
            '<tr><td>' . $value['id'] . '</td><td>' . $value['resource'] . '</td></tr>';
        }
        return $content;
    }

    function createRoleSelectHtml() {
        global $connection;
        $roles = getRoles($connection);
        $content = '';
        foreach ($roles as $key => $value) {
            $content = $content . '<option>' . $value['role'] . '</option>';
        }
        return $content;
    }
}
?>