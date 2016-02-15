<?php
require_once((dirname(__DIR__)) . '/resources/db_connection.php');

$tableColumns = array( 'id', 'userName', 'firstName', 'middleName', 'lastName', 'role_id', 'suffix', 
    'gender', 'dateOfBirth', 'maritalStatus', 'employmentStatus', 'employer', 'email', 
    'street', 'city', 'state', 'zip', 'telephone', 'mobile', 'fax', 'edit', 'delete');

$output = array("aaData" => array());

$query = mysqli_query($connection, "SELECT id, userName, firstName, middleName, lastName, 
    role_id, suffix, gender, dateOfBirth, maritalStatus, employmentStatus, employer, email, 
    street, city, state, zip, telephone, mobile, fax
    FROM employee_details");

$roleArray = array();
$query2 = mysqli_query($connection, "SELECT id, role FROM roles");
if ($query2) {
    while ($record2 = mysqli_fetch_assoc($query2)) {
        $roleArray[$record2['id']] = $record2['role'];
    }
}

if ($query) {
    while ($record = mysqli_fetch_assoc($query)) {
        $row = array();
        $numberOfColumns = count($tableColumns);

        for ( $i = 0; $i < $numberOfColumns; $i++ )
        {
            if (0 == $i || 1 == $i) {
                $row[] = $record[ $tableColumns[$i] ];
            }
            
            else if (5 == $i) {
                $id = $record[ $tableColumns[0] ];
                $name = $tableColumns[$i] . $id;

                $comboBox = '<select class="invisibleBox" 
                onchange="updateRecord('. '\'' . $id .'\',' .'\'' . $name . '\',' .
                '\'' . $tableColumns[$i] . '\')" id=' . $name . '>';
                foreach ($roleArray as $key => $value) {
                    $param = '';
                    if ($record[ $tableColumns[$i] ] == $key) {
                        $param = 'selected';
                    }
                    else {
                        $param = '';
                    }
                    $comboBox = $comboBox . '<option ' . $param . ' value=' . $key . '>' . $value . '</option>';
                }
                $comboBox = $comboBox . '</select>';
                $row[] = $comboBox;
            }

            else if ($i == ($numberOfColumns - 2)) {
                $userName = trim($record['userName']);
                $row[] = '<input name="' . $userName . '" id="' . $userName . '" type="button"
                class="edit-button btn btn-primary" 
                onclick="editRecord(' . htmlentities(json_encode($record)) . ')" value="Edit">';
            }
            else if ($i == ($numberOfColumns - 1)) {
                $row[] = '<input name="' . $userName . '" id="' . $userName . '" type="button"
                class="delete-button btn btn-primary" 
                onclick="confirmDeletion(' .'\'' . $userName . '\'' . ')" value="Delete">';
            }
            else {
                $value = $record[ $tableColumns[$i] ];
                $id = $record[ $tableColumns[0] ];
                $name = $tableColumns[$i] . $id;
                
                $row[] = '<input value="' . $value .'" class="invisibleBox" type="text" 
                onchange="updateRecord('. '\'' . $id .'\',' .'\'' . $name . '\',' .
                '\'' . $tableColumns[$i] . '\')"' . 'id="' . $name . '">';
                
                //$row[] = $record[ $tableColumns[$i] ];
            }
        }
        $output['aaData'][] = $row;

    }
    echo json_encode( $output );
}
?>