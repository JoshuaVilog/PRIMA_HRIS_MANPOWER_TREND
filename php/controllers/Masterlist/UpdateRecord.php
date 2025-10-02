<?php
require_once __DIR__ . '/../../models/MasterlistModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $desc = $_POST['desc'];
    $category = $_POST['category'];
    $id = $_POST['id'];

    try {
        $record = new MasterlistModel();

        $record->desc = $desc;
        $record->category = $category;
        $record->id = $id;

        $isDuplicate = $record::CheckDuplicate($record);

        if($isDuplicate == true){

            echo json_encode(['status' => 'duplicate', 'message' => '']);
        } else if($isDuplicate == false){

            $record::UpdateRecord($record);
            echo json_encode(['status' => 'success', 'message' => '']);
        }

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}