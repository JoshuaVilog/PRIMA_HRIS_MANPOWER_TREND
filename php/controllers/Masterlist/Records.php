<?php
require_once __DIR__ . '/../../models/MasterlistModel.php';

header('Content-Type: application/json');

try {
    $records = MasterlistModel::DisplayRecords();
    echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
