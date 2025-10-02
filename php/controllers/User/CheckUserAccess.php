<?php
require_once __DIR__ . '/../../models/UserModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $rfid = $_POST['rfid'];
    $rfid = $_SESSION['USER_CODE'];

    try {
        $records = UserModel::CheckUserAccess($rfid);
        
        echo json_encode($records);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}