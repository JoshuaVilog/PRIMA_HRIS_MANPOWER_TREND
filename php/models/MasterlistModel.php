<?php
require_once __DIR__ . '/../../config/db.php';

class MasterlistModel {
    
    public static function DisplayRecords() {
        $db = DB::connection1();
        $sql = "SELECT * FROM masterlist WHERE COALESCE(DELETED_AT, '') = '' ORDER BY RID DESC";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }

    public static function GetRecord($id){
        $db = DB::connection1();

        $sql = "SELECT * FROM masterlist WHERE RID = $id";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }
    public static function CheckDuplicate($records){
        $db = DB::connection1();

        $desc = $db->real_escape_string($records->desc);
        $category = $db->real_escape_string($records->category);
        $id = $db->real_escape_string($records->id);
        $find = $desc."_".$category;

        $sql = "SELECT RID FROM masterlist WHERE CONCAT(DESCRIPTION, '_', CATEGORY, COALESCE(DELETED_AT, '')) = '$find' AND RID != $id";
        $result = mysqli_query($db, $sql);

        if(mysqli_num_rows($result) == 0){
            return false;
        } else {
            return true;
        }
    }

    public static function InsertRecord($records){
        $db = DB::connection1();
        $userCode = $_SESSION['USER_CODE'];

        $desc = $db->real_escape_string($records->desc);
        $category = $db->real_escape_string($records->category);

        $sql = "INSERT INTO `masterlist`(
            `RID`,
            `DESCRIPTION`,
            `CATEGORY`,
            `CREATED_BY`
        )
        VALUES(
            DEFAULT,
            '$desc',
            '$category',
            '$userCode'
        )";
        return $db->query($sql);
    }
    public static function UpdateRecord($records){
        $db = DB::connection1();
        $userCode = $_SESSION['USER_CODE'];

        $desc = $db->real_escape_string($records->desc);
        $category = $db->real_escape_string($records->category);
        $id = $records->id;

        $sql = "UPDATE
            `masterlist`
        SET
            `DESCRIPTION` = '$desc',
            `CATEGORY` = '$category',
            `UPDATED_BY` = '$userCode'
        WHERE
            `RID` = $id";
        return $db->query($sql);
    }
    public static function RemoveRecord($id){
        $db = DB::connection1();
        $userCode = $_SESSION['USER_CODE'];

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "UPDATE
            `masterlist`
        SET
            `DELETED_AT` = '$createdAt',
            `DELETED_BY` = '$userCode'
        WHERE
            `RID` = $id";
        
        return $db->query($sql);
    }


}

?>