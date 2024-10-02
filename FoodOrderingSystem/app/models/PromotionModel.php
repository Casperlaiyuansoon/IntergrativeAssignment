<?php
include_once 'BaseModel_roger.php';

class PromotionModel extends BaseModel_roger {
    // Define the table and primary key
    protected $table = 'promotions';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct(); // Call the parent constructor to establish a connection
    }

    // Add a new promotion (insert)
    public function addPromotion(array $data) {
        // Check for necessary keys in the data array to prevent errors
        if (!isset($data['title'], $data['description'], $data['discount_percentage'], $data['start_date'], $data['end_date'])) {
            throw new Exception("Missing required promotion fields.");
        }
        // Use prepared statements for database interaction (assumed to be handled in BaseModel)
        return $this->save($data); // Use the save() method from BaseModel to insert
    }

    // Update an existing promotion
    public function updatePromotion(array $data) {
        // Check for necessary keys to ensure a valid update
        if (!isset($data[$this->primaryKey])) {
            throw new Exception("Primary key is required for update.");
        }
        // Use prepared statements for database interaction (assumed to be handled in BaseModel)
        return $this->save($data); // Use save() from BaseModel, it will detect the primary key and update
    }

    // Get all promotions
    public function getAllPromotions() {
        // Implement error handling for database interactions
        try {
            return $this->all(); // Use the all() method from BaseModel
        } catch (Exception $e) {
            error_log($e->getMessage()); // Log the error message
            throw new Exception("Could not retrieve promotions.");
        }
    }

    // Get a single promotion by ID
    public function getPromotionById($id) {
        // Validate ID format (assuming it should be an integer)
        if (!is_numeric($id)) {
            throw new Exception("Invalid promotion ID.");
        }
        // Implement error handling for database interactions
        try {
            return $this->find($id); // Use the find() method from BaseModel
        } catch (Exception $e) {
            error_log($e->getMessage()); // Log the error message
            throw new Exception("Promotion not found.");
        }
    }

    // Delete a promotion by ID
    public function deletePromotion($id) {
        // Validate ID format (assuming it should be an integer)
        if (!is_numeric($id)) {
            throw new Exception("Invalid promotion ID.");
        }
        // Implement error handling for database interactions
        try {
            return $this->delete($id); // Use the delete() method from BaseModel
        } catch (Exception $e) {
            error_log($e->getMessage()); // Log the error message
            throw new Exception("Could not delete promotion.");
        }
    }
}
?>
