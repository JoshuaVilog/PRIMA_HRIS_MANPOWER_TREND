<?php
require_once __DIR__ . '/../../config/db.php';

class UserModel {
    public static function getAllUsers() {
        $db = DB::connection1();
        $sql = "SELECT * FROM user";
        $result = $db->query($sql);

        $users = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        return $users;
    }

    public static function CheckAccount($username, $password){
        $db = DB::connection1();

        $password = md5($password);

        $sql = "SELECT * FROM user WHERE USERNAME = '$username' AND PASSWORD = '$password'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }

    public static function InsertLoginHistory($userID){
        $db = DB::connection1();

        $sql = "INSERT INTO `login_history`(`RID`, `USER_ID`)
        VALUES(
            DEFAULT,
            '$userID'
        )";
        return $db->query($sql);

    }

    public static function CheckUserAccess($rfid){
        $db = DB::connection1();

        $sql = "SELECT * FROM user WHERE RFID = '$rfid'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }
    public static function GetUserInfo(){
        $db = DB::connectionHRIS();
        $userCode = $_SESSION['USER_CODE'];

        $sql = "SELECT EMPLOYEE_ID, RFID, EMPLOYEE_NAME, F_NAME, L_NAME, M_NAME FROM 1_hris.1_employee_masterlist_tb WHERE RFID = '$userCode'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }


}

?>