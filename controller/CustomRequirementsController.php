<?php
// controller/CustomRequirementsController.php

header('Content-Type: application/json');
session_start();

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../model/CustomRequirementsModel.php';

$action = $_REQUEST['action'] ?? '';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$db = (new Database())->connect();
$model = new CustomRequirementsModel($db);

switch ($action) {
    case 'read':
        $rows = $model->readAll();
        echo json_encode($rows);
        break;

    case 'update_status':
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        if ($id <= 0 || !in_array($status, ['pending','approved','done'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
            break;
        }
        if ($model->updateStatus($id, $status)) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
        break;

    case 'delete':
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            break;
        }
        if ($model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Record deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
