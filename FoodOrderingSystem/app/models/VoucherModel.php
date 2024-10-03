<?php
include_once 'BaseModel_roger.php'; // Ensure BaseModel is included

class VoucherModel extends BaseModel_roger {
    protected $table = 'vouchers'; // Set the table name
    private $table_name = "promotions"; // Set the promotions table name
    protected $primaryKey = 'id';  // Set the primary key field


    
     // Method to get promotion by ID
     public function getPromotionById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    // Fetch all promotions (useful if needed later)
    public function getAllPromotions() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Method to create a new voucher
    public function createVoucher($data) {
        // Use save method from BaseModel to handle insert
        return $this->save($data); 
    }

    public function getVoucherAmount($code){
        $query = "SELECT * FROM {$this->table} WHERE code = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $code, PDO::PARAM_STR);  // CHANGE: Using PDO bindValue for code
        $stmt->execute();

        $amount = null;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){  // CHANGE: Using PDO fetch(PDO::FETCH_ASSOC)
            $amount = $row['discount_percentage'];  // CHANGE: Corrected to 'discount_percentage'
        }

        return $amount;
    }

    // Fetch voucher details by voucher code
     // Fetch voucher by voucher code
     public function getVoucherByCode($code) {
        $query = "SELECT * FROM {$this->table} WHERE code = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function incrementVoucherUsage($voucher_id) {
        $query = "UPDATE {$this->table} SET times_used = times_used + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $voucher_id, PDO::PARAM_INT);  // CHANGE: Using PDO bindValue for voucher_id
        return $stmt->execute();
    }

    // Fetch all vouchers
    public function getAllVouchers() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($query);  // CHANGE: PDO query instead of MySQLi query

        if ($stmt === false) {
            // Handle query error
            return [];
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // CHANGE: fetchAll() for PDO
    }

    // Method to update an existing voucher
    public function updateVoucher($id, $data) {
        $query = "UPDATE {$this->table} SET code = ?, promotion_id = ?, expiration_date = ?, discount_percentage = ?, max_uses = ?, times_used = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $data['code'], PDO::PARAM_STR);  // CHANGE: bindValue for each parameter
        $stmt->bindValue(2, $data['promotion_id'], PDO::PARAM_INT);
        $stmt->bindValue(3, $data['expiration_date'], PDO::PARAM_STR);
        $stmt->bindValue(4, $data['discount_percentage'], PDO::PARAM_INT);
        $stmt->bindValue(5, $data['max_uses'], PDO::PARAM_INT);
        $stmt->bindValue(6, $data['times_used'], PDO::PARAM_INT);
        $stmt->bindValue(7, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Method to delete a voucher
    public function deleteVoucher($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);  // CHANGE: Using PDO bindValue for id
        return $stmt->execute();
    }
    
    // Method to fetch a voucher by its ID
    public function getVoucherById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);  // CHANGE: Using PDO bindValue for id
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // CHANGE: fetch() for PDO
    }

// Method to check if a voucher code already exists, excluding the current voucher
public function isDuplicateCode($code, $currentId = null) {
    $query = "SELECT * FROM {$this->table} WHERE code = ? AND id != ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(1, $code, PDO::PARAM_STR);
    $stmt->bindValue(2, $currentId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function vouchersToXML($vouchers) {
        $xml = new SimpleXMLElement('<vouchers/>');

        foreach ($vouchers as $voucher) {
            $voucherNode = $xml->addChild('voucher');
            $voucherNode->addChild('code', htmlspecialchars($voucher['code']));
            $voucherNode->addChild('promotion_id', $voucher['promotion_id']);
            $voucherNode->addChild('expiration_date', $voucher['expiration_date']);
            $voucherNode->addChild('discount_percentage', $voucher['discount_percentage']);
            $voucherNode->addChild('max_uses', $voucher['max_uses']);
            $voucherNode->addChild('times_used', $voucher['times_used']);
        }

        return $xml->asXML();
    }
}
