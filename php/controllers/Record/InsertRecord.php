<?php
require_once __DIR__ . '/../../models/RecordModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $desc = $_POST['desc'];

    try {
        $record = new RecordModel();

        $record->desc = $desc;
        
        $isDuplicate = $record::CheckDuplicate($desc);

        if($isDuplicate == true){
            $id = $record::GetDuplicateID($desc);

            echo json_encode(['status' => 'duplicate', 'message' => '', 'id' => $id]);
        } else if($isDuplicate == false){

            $id = $record::InsertRecord($record);
            echo json_encode(['status' => 'success', 'message' => '', 'id' => $id]);
        }

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}