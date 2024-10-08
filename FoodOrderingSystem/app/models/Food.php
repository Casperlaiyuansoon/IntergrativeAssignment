<?php

require_once '../../config/Database.php';
require_once '../../observers/Subject.php';
require_once 'BaseModel.php';

class Food extends BaseModel implements Subject {

    protected $conn;
    protected $table = "food_items"; //table name
    private $observers = []; // List of observers
    private $foodData; // Data to be passed to observers
    public $id;
    public $name;
    public $price;
    public $image;

    // Constructor with Database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Attach an observer to the subject
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    // Detach an observer from the subject
    public function detach(Observer $observer) {
        foreach ($this->observers as $key => $value) {
            if ($value === $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    // Notify all observers of the change
    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this->foodData);
        }
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getImage() {
        return $this->image;
    }

    //Setter
    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setPrice($price): void {
        $this->price = $price;
    }

    public function setImage($image): void {
        $this->image = $image;
    }

    public function save() {
        $data = [
            'name' => $this->name,
            'price' => $this->price,
            'image' => $this->image
        ];

        if (isset($this->id)) {
            return $this->update($this->id, $data); // Update the record
        } else {
            return $this->create($data); // Create a new record
        }
    }

    // Delete a food item
    public function remove() {
        return $this->delete($this->id);
    }

    // Find a food item by ID
    public function findFood($id) {
        $foodData = $this->find($id);
        if ($foodData) {
            $this->id = $foodData['id'];
            $this->name = $foodData['name'];
            $this->price = $foodData['price'];
            $this->image = $foodData['image'];
        }
        return $foodData;
    }

    // ===========================Create food=======================================
//    public function create() {
//        $query = "INSERT INTO " . $this->table . " (name, price, image) VALUES (:name, :price, :image)";
//        $stmt = $this->conn->prepare($query);
//
//        // Strongly typing input parameters
//        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);  // Name is a string
//        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR); // Price is stored as string (decimal)
//        $stmt->bindParam(':image', $this->image, PDO::PARAM_STR); // Image name as string
//
//
//        if ($stmt->execute()) {
//            // Notify observers with relevant data
//            //$this->foodData = ['action' => 'create', 'name' => $this->name, 'price' => $this->price];
//            //$this->notify();
//            return true;
//        }
//        return false;
//    }
    // ===========================Update food=======================================
//    public function update() {
//        $query = "UPDATE " . $this->table . " SET name = :name, price = :price, image = :image WHERE id = :id";
//        $stmt = $this->conn->prepare($query);
//
//        $stmt->bindParam(":name", $this->name);
//        $stmt->bindParam(":price", $this->price);
//        $stmt->bindParam(":image", $this->image);
//        $stmt->bindParam(":id", $this->id);
//
//        if ($stmt->execute()) {
//            return true;
//        }
//        return false;
//    }
    // ===========================Delete food=======================================
//    public function delete() {
//        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
//        $stmt = $this->conn->prepare($query);
//        $stmt->bindParam(":id", $this->id);
//
//        if ($stmt->execute()) {
//            return true;
//        }
//        return false;
//    }
    // ===========================Read food=======================================
//    public function read() {
//        $query = "SELECT * FROM " . $this->table;
//        $stmt = $this->conn->prepare($query);
//        $stmt->execute();
//        return $stmt;
//    }
    // ===========================Search by name=======================================
    public function searchByName($searchTerm) {
        $query = "SELECT * FROM " . $this->table . " WHERE name LIKE :searchTerm";
        $stmt = $this->conn->prepare($query);

        // Bind search term with wildcards for partial matching
        $searchTerm = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchTerm);

        $stmt->execute();
        return $stmt;
    }
}
