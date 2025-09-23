<?php
class BannerModel
{
    private $conn;
    private $table = "banners";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

     public function create($data) {
        $tagline = $data['tagline'];
        $sub_text = $data['sub_text'];
        $cta_button_text = $data['cta_button_text'];
        $cta_button_link = $data['cta_button_link'];
        $display_order = (int)$data['display_order'];
        $image_path = $data['image_path']; // Assuming you already handled upload

        // Step 1: Shift existing banners if display_order conflicts
        $shiftSql = "UPDATE {$this->table} SET display_order = display_order + 1 WHERE display_order >= ?";
        $stmtShift = $this->conn->prepare($shiftSql);
        $stmtShift->bind_param("i", $display_order);
        $stmtShift->execute();

        // Step 2: Insert new banner
        $insertSql = "INSERT INTO {$this->table} 
            (image_path, tagline, sub_text, cta_button_text, cta_button_link, display_order, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmtInsert = $this->conn->prepare($insertSql);
        $stmtInsert->bind_param("sssssi", $image_path, $tagline, $sub_text, $cta_button_text, $cta_button_link, $display_order);

        return $stmtInsert->execute();
    }

    public function read()
    {
        $result = $this->conn->query("SELECT * FROM {$this->table} ORDER BY display_order ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // public function delete($id) {
    //     $sql = "DELETE FROM {$this->table} WHERE id=?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bind_param("i", $id);
    //     return $stmt->execute();
    // }

    public function delete($id)
    {
        $id = intval($id);

        // Step 1: Fetch old image path from DB
        $result = $this->conn->query("SELECT image_path FROM {$this->table} WHERE id=$id");
        if ($result && $row = $result->fetch_assoc()) {
            $oldImage = $row['image_path'];

            // Step 2: Delete file from uploads folder if it exists
            if (!empty($oldImage) && file_exists(__DIR__ . "/../" . $oldImage)) {
                unlink(__DIR__ . "/../" . $oldImage);
            }
        }

        // Step 3: Delete database row
        return $this->conn->query("DELETE FROM {$this->table} WHERE id=$id");
    }


    public function toggleStatus($id, $is_active)
    {
        $sql = "UPDATE {$this->table} SET is_active=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $is_active, $id);
        return $stmt->execute();
    }
}
