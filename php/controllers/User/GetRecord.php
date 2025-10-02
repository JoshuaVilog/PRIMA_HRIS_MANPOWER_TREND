<?php
require_once __DIR__ . '/../../models/UserModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $rfid = $_POST['rfid'];

    try {
        $records = UserModel::GetUserInfo();
        
        echo json_encode($records);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}