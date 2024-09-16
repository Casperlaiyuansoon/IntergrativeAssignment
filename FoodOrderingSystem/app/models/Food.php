<?php

require_once '../../config/Database.php';

class Food {

    private $observers = [];
    private $conn;
    private $table = "food_items"; //table name
    
    public $id;
    public $name;
    public $price;
    public $image;

    // Constructor with Database connection
    public function __construct($db) {
        $this->conn = $db;
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

    // ===========================Create food=======================================
    public function create() {
        $query = "INSERT INTO " . $this->table . " (name, price, image) VALUES (:name, :price, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':image', $this->image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ===========================Update food=======================================
    public function update() {
        $query = "UPDATE " . $this->table . " SET name = :name, price = :price, image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ===========================Delete food=======================================
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ===========================Read food=======================================
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

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



    // ===========================observer design pattern=======================================
    public function addObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer) {
        $this->observers = array_filter($this->observers, function ($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    public function notifyObservers($foodItem) {
        foreach ($this->observers as $observer) {
            $observer->update($foodItem);
        }
    }

    // CRUD methods that trigger notifications
    public function addFood($name, $price, $image) {
        $this->notifyObservers(['action' => 'add', 'name' => $name, 'price' => $price, 'image' => $image]);
    }

    public function updateFood($id, $name, $price, $image) {
        $this->notifyObservers(['action' => 'update', 'id' => $id, 'name' => $name, 'price' => $price, 'image' => $image]);
    }

    public function deleteFood($id) {
        $this->notifyObservers(['action' => 'delete', 'id' => $id]);
    }

}
