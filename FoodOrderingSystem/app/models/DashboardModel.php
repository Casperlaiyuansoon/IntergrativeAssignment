<?php
class DashboardModel {
    private $db;

    public function __construct($database) {
        $this->db = $database->getConnection();
    }

    public function getTotalCustomers() {
        $query = "SELECT COUNT(*) FROM user";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalMenuItems() {
        $query = "SELECT COUNT(*) FROM food_items";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalOrders() {
        $query = "SELECT COUNT(*) FROM ordermain";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalSales() {
        $query = "SELECT SUM(orderAmount) FROM ordermain"; // Assuming there's a total_amount field
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
