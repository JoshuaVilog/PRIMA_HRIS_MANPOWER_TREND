<?php
require_once __DIR__ . '/../../config/db.php';


class EmployeeModel {

    public static function CheckAccount($username, $password){
        $db = DB::connectionHRIS();

        //$password = md5($password);

        $sql = "SELECT EMPLOYEE_ID, EMPLOYEE_NAME, RFID, PASSWORD, ACTIVE, ROLE FROM 1_employee_masterlist_tb WHERE RFID = '$username'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['PASSWORD'])) {
                return $row;
            } else {
                echo null;
            }
        }
    }

    public static function DisplayEmployeeRecords() {
        $db = DB::connectionHRIS();
        $sql = "SELECT EMPLOYEE_ID, RFID, EMPLOYEE_NAME, F_NAME, L_NAME, M_NAME, JOB_POSITION_ID, DEPARTMENT_ID, ACTIVE, BIO_USER_ID FROM 1_hris.1_employee_masterlist_tb WHERE DELETED_STATUS = '0'";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }
    public static function DisplayDepartmentRecords() {
        $db = DB::connectionHRIS();
        $sql = "SELECT `DEPARTMENT_ID`,`DEPARTMENT_CODE`, `DEPARTMENT_NAME` FROM `department_tb`";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }
    
    public static function DisplayJobPositionRecords() {
        $db = DB::connectionHRIS();
        $sql = "SELECT `JOB_POSITION_ID`, `JOB_TITLE`, `JOB_LEVEL_ID` FROM `job_position_tb`";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }

    public static function GetTimekeepingRecords($startDate, $endDate) {
        $db = DB::connectionHRIS();

        $endDate = date("Y-m-d", strtotime($endDate . " +1 day"));

        $records = [];

        $sql1 = "SELECT
            DATE(ATTENDANCE_TIMESTAMP) AS `DATE`,
            ATTENDANCE_BIO_USER_ID AS `BIO_USER_ID`,
            MIN(CASE WHEN ATTENDANCE_TYPE = 'I' THEN ATTENDANCE_TIMESTAMP END) AS `IN`,
            MAX(CASE WHEN ATTENDANCE_TYPE = 'O' THEN ATTENDANCE_TIMESTAMP END) AS `OUT`
        FROM 
            4_timekeeping_ptpi_tb
        WHERE 
            ATTENDANCE_TIMESTAMP BETWEEN '$startDate' AND '$endDate'
        GROUP BY 
            DATE(ATTENDANCE_TIMESTAMP), 
            ATTENDANCE_BIO_USER_ID
        ORDER BY
            ATTENDANCE_BIO_USER_ID,
            DATE(ATTENDANCE_TIMESTAMP)";
        $result1 = $db->query($sql1);
        
        if ($result1 && $result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                $records[] = $row1;
            }
        }

        $sql2 = "SELECT
            DATE(ATTENDANCE_TIMESTAMP) AS `DATE`,
            ATTENDANCE_BIO_USER_ID AS `BIO_USER_ID`,
            MIN(CASE WHEN ATTENDANCE_TYPE = 'I' THEN ATTENDANCE_TIMESTAMP END) AS `IN`,
            MAX(CASE WHEN ATTENDANCE_TYPE = 'O' THEN ATTENDANCE_TIMESTAMP END) AS `OUT`
        FROM 
            4_timekeeping_agency_tb
        WHERE 
            ATTENDANCE_TIMESTAMP BETWEEN '$startDate' AND '$endDate'
        GROUP BY 
            DATE(ATTENDANCE_TIMESTAMP), 
            ATTENDANCE_BIO_USER_ID
        ORDER BY
            ATTENDANCE_BIO_USER_ID,
            DATE(ATTENDANCE_TIMESTAMP)";
        $result2 = $db->query($sql2);
        
        if ($result2 && $result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                $records[] = $row2;
            }
        }

        return $records;
    }

}