<?php
// model/CustomRequirementsModel.php

class CustomRequirementsModel {
    private $conn;
    private $table = "custom_requirements";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        if (!$result) {
            error_log("readAll: " . $this->conn->error);
            return [];
        }
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET status = ? WHERE id = ?");
        if (!$stmt) {
            error_log("updateStatus prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("si", $status, $id);
        $res = $stmt->execute();
        if (!$res) {
            error_log("updateStatus execute failed: " . $stmt->error);
        }
        $stmt->close();
        return $res;
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        if (!$stmt) {
            error_log("delete prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        $res = $stmt->execute();
        if (!$res) {
            error_log("delete execute failed: " . $stmt->error);
        }
        $stmt->close();
        return $res;
    }
}
