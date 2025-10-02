<?php
require_once __DIR__ . '/../../models/MasterlistModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];

    try {
        $records = MasterlistModel::GetRecord($id);
        
        echo json_encode($records);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}