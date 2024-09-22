<?php

class OrderModel extends BaseModel {
    protected $table = 'orders'; // Set the table name
    protected $primaryKey = 'id';  // Set the primary key field

    // Save order to the database
    public function saveOrder($data) {
        // Prepare data for insertion
        $data = [
            'customer_id' => $data['customer_id'],
            'total_amount' => $data['total_amount'],
            'voucher_code' => $data['voucher_code'],
            'discount_amount' => $data['discount_amount'],
            'final_amount' => $data['final_amount']
        ];

        return $this->save($data); // Use the save method from BaseModel
    }
    
    // Fetch order details by order ID
    public function getOrderById($id) {
        return $this->find($id); // Use the find method from BaseModel
    }

    // Get all orders
    public function getAllOrders() {
        return $this->all(); // Use the all method from BaseModel
    }
}

?>
