<?php

require_once '../config/database.php';


class Menu {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getConnection();
    }
    
    public function getAllMenus(){
        $stmt = $this->pdo->query("SELECT * FROM menu");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);    
    }
    
    public function getMenu($menuId) {
        $stmt = $this->pdo->prepare("SELECT * FROM menu WHERE menuId = :menuId");
        $stmt->execute([':menuId' => $menuId]);
        return $stmt->fetch(PDO::FETEH_ASSOC);
    }
    
      public function addMenu($image, $name, $price) {
        $stmt = $this->pdo->prepare("INSERT INTO menu (image, name, price) VALUES (:image, :name, :price)");
        return $stmt->execute([
            ':image' => $image,
            ':name' => $name,
            ':price' => $price,
        ]);
    }
    
        public function updateMenu($menuId, $image, $name, $price) {
        $stmt = $this->pdo->prepare("UPDATE menu SET image = :image, name = :name, price = :price WHERE menuId = :menuId");
        return $stmt->execute([
            ':menuId' => $menuId,
            ':image' => $image,
            ':name' => $name,
            ':price' => $price,

        ]);
    }
    
        public function deleteMenu($menuId) {
        $stmt = $this->pdo->prepare("DELETE FROM menu WHERE menuId = :menuId");
        return $stmt->execute([':menuId' => $menuId]);
    }
    
    
    
}



