<?php

include_once '../config/database.php'; 
class BaseModel_roger {
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct() {
        // Assume DatabaseConnection is already set up
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Save method to handle insert or update
    public function save(array $data) {
        if (isset($data[$this->primaryKey])) {
            // Update case
            $id = $data[$this->primaryKey];
            unset($data[$this->primaryKey]); // Remove the primary key for the update fields

            $columns = array_keys($data);
            $setColumns = implode(' = ?, ', $columns) . ' = ?';

            $query = "UPDATE {$this->table} SET $setColumns WHERE {$this->primaryKey} = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                throw new Exception("Failed to prepare update query.");
            }

            $values = array_values($data);
            $values[] = $id; // Add the ID to the end for the WHERE clause
            
            // PDO binding with positional placeholders
            foreach ($values as $index => $value) {
                $stmt->bindValue($index + 1, $value);  // CHANGE: bindValue for each parameter
            }

            return $stmt->execute();  // CHANGE: PDO execute without MySQLi's bind_param
        } else {
            // Insert case
            $columns = array_keys($data);
            $placeholders = implode(', ', array_fill(0, count($columns), '?'));
            $query = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES ($placeholders)";
            
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                throw new Exception("Failed to prepare insert query.");
            }

            $values = array_values($data);
            
            // PDO binding with positional placeholders
            foreach ($values as $index => $value) {
                $stmt->bindValue($index + 1, $value);  // CHANGE: bindValue for each parameter
            }

            return $stmt->execute();  // CHANGE: PDO execute without MySQLi's bind_param
        }
    }

    // Find method to get a record by ID
    public function find($id) {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);  // CHANGE: Using PDO::PARAM_INT
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // CHANGE: fetch() for PDO instead of get_result()->fetch_assoc()
    }

    // Find all records
    public function findAll() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($query);  // CHANGE: PDO query instead of MySQLi query
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // CHANGE: fetchAll() for PDO instead of fetch_all()
    }

    // Get all records
    public function all() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($query);  // CHANGE: PDO query instead of MySQLi query
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // CHANGE: fetchAll() for PDO instead of fetch_all()
    }

    // Delete a record by ID
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);  // CHANGE: Using PDO::PARAM_INT
        return $stmt->execute();  // CHANGE: PDO execute instead of MySQLi execute
    }
}
