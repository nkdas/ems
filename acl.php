<?php
//namespace acl;

/**
 * This page checks privileges for a user.
 *
 * @author Neeraj Kumar Das <neeraj.das@mindfiresolutions.com>
 */

// Turn ON error reporting
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'resources/db_connection.php';

class acl
{
    /**
     * Function to check privilege for a user.
     *
     * @param int $userId     Id of the user
     * @param int $resourceId Id of the resource
     *
     * @return array $privilege Ids of the privileges the user holds for the resource
     */
    public function checkPrivilege($userId, $resourceId)
    {
        global $connection;
        $privilege = array();

        $query = 'SELECT urp.privilege_id
        FROM user_resource_privilege urp
        WHERE urp.resource_id = '.$resourceId.' AND 
        urp.role_id = (SELECT role_id FROM employee_details WHERE id = '.$userId.')';

        $sql = mysqli_query($connection, $query);

        if ($sql) {
            $row = array();
            while ($row = mysqli_fetch_assoc($sql)) {
                array_push($privilege, $row['privilege_id']);
            }
        }

        return $privilege;
    }
}
