<?php

require_once(dirname(__DIR__)).'/resources/db_connection.php';
require(dirname(__DIR__)).'/db_functions.php';

if (isset($_SESSION['pk_admin'])) {
    // recieve ajax post
    $createObject = new CreateHtml();
    if (isset($_POST['item'])) {
        if ('role' == $_POST['item']) {
            $status = $createObject->createRolesHtml();
            echo $status;
        } elseif ('resource' == $_POST['item']) {
            $status = $createObject->createResourceHtml();
            echo $status;
        } else {
            $status = $createObject->createRoleSelectHtml();
            echo $status;
        }
    }
} else {
    header('Location: index.php');
}

class createHtml
{
    public function createRolesHtml()
    {
        global $connection;
        $roles = getRoles($connection);

        $content = '<thead><tr><th>ID</th><th>ROLE</th></tr></thead>';

        foreach ($roles as $key => $value) {
            $content = $content.
            '<tr><td>'.$value['id'].'</td><td>'.$value['role'].'</td></tr>';
        }

        return $content;
    }

    public function createResourceHtml()
    {
        global $connection;
        $resources = getResources($connection);

        $content = '<thead><tr><th>ID</th><th>RESOURCE</th></tr></thead>';

        foreach ($resources as $key => $value) {
            $content = $content.
            '<tr><td>'.$value['id'].'</td><td>'.$value['resource'].'</td></tr>';
        }

        return $content;
    }

    public function createRoleSelectHtml()
    {
        global $connection;
        $roles = getRoles($connection);
        $content = '';
        foreach ($roles as $key => $value) {
            $content = $content.'<option>'.$value['role'].'</option>';
        }

        return $content;
    }
}
