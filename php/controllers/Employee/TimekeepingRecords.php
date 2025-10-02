<?php
require_once __DIR__ . '/../../models/EmployeeModel.php';

header('Content-Type: application/json');

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

try {
    $records = EmployeeModel::GetTimekeepingRecords($startDate, $endDate);
    
    $newRecords = [];
    foreach ($records as $row) {
        $row['DEPT'] = setDeptByBioUserID($row['BIO_USER_ID']);

        $newRecords[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $newRecords]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

function setDeptByBioUserID($bioUserID) {
    $employeeRecords = EmployeeModel::DisplayEmployeeRecords();

    foreach ($employeeRecords as $emp) {
        if ($emp['BIO_USER_ID'] == $bioUserID) {
            return $emp['DEPARTMENT_ID'];
        }
    }
    return null;
}
?>
