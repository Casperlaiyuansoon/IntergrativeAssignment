<?php
include_once 'BaseModel_roger.php'; // Ensure BaseModel is included

class VoucherModel extends BaseModel {
    protected $table = 'vouchers'; // Set the table name
    protected $primaryKey = 'id';  // Set the primary key field

    // Method to create a new voucher
    public function createVoucher($data) {
        // Use save method from BaseModel to handle insert
        return $this->save($data); 
    }

    public function getVoucherAmount($code){

        $query = "SELECT * FROM {$this->table} WHERE code = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $code);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $amount = $row['DISCOUNT_PERCENTAGE'];
        }

        return $amount;

    }

    // Fetch voucher details by voucher code
    public function getVoucherByCode($code) {
        $query = "SELECT * FROM {$this->table} WHERE code = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function incrementVoucherUsage($voucher_id) {
        $query = "UPDATE {$this->table} SET times_used = times_used + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $voucher_id);
        $stmt->execute();
    }

    // Fetch all vouchers
    public function getAllVouchers() {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($query);

        if ($result === false) {
            // Handle query error
            return [];
        }

        $vouchers = [];
        while ($row = $result->fetch_assoc()) {
            $vouchers[] = $row;
        }

        return $vouchers;
    }

    // Method to update an existing voucher
    public function updateVoucher($id, $data) {
        $query = "UPDATE {$this->table} SET code = ?, promotion_id = ?, expiration_date = ?, discount_percentage = ?, max_uses = ?, times_used = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siisiii", $data['code'], $data['promotion_id'], $data['expiration_date'], $data['discount_percentage'], $data['max_uses'], $data['times_used'], $id);
        
        return $stmt->execute();
    }

    // Method to delete a voucher
    public function deleteVoucher($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    // Method to fetch a voucher by its ID
public function getVoucherById($id) {
    $query = "SELECT * FROM {$this->table} WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
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
?>
