<?php

include_once 'DatabaseConnection.php'; 
class BaseModel {
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct() {
        // Assume DatabaseConnection is already set up
        $this->conn = DatabaseConnection::getInstance();
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
                throw new Exception("Failed to prepare update query: " . $this->conn->error);
            }

            $types = str_repeat('s', count($data)); // Assuming all fields are strings
            $values = array_values($data);
            $values[] = $id; // Add the ID to the end for the WHERE clause

            $stmt->bind_param($types . 'i', ...$values); // Append 'i' for ID
            return $stmt->execute();
        } else {
            // Insert case
            $columns = array_keys($data);
            $placeholders = implode(', ', array_fill(0, count($columns), '?'));
            $query = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES ($placeholders)";
            
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                throw new Exception("Failed to prepare insert query: " . $this->conn->error);
            }

            $types = str_repeat('s', count($data)); // Assuming all fields are strings
            $values = array_values($data);
            $stmt->bind_param($types, ...$values);
            return $stmt->execute();
        }
    }

    // Find method to get a record by ID
    public function find($id) {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
public function findAll() {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    // Get all records
    public function all() {
        $query = "SELECT * FROM {$this->table}";
        return $this->conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    // Delete a record by ID
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
        
        
    }
    
    
}
