<?php

require_once '../app/model/Menu.php';

class MenuController{
    private $menuModel;
    
    
    public function __construct() {
        $this->menuModel = new Menu();
    }
    
    public function listMenus(){
         $menus = $this->menuModel->getAllMenus();
         include '../app/view/admin_menu.php';
    }
    
    public function showMenuForm($menuId = null){
        $menu = null;
        if ($menuId){
            $menu = $this->menuModel->getMenu($menuId);
        }
        include '../app/view/admin_menu.php';
    }
    
    public function saveMenu(){
             $menuId = $_POST['menuId'] ?? null;
             $image = $_POST['image'];
             $name = $_POST['name'];
             $price = $_POST['price'];
             
             if($menuId){
                 $this->menuModel->updateMenu($menuId, $image, $name, $price);
             }else {
                 $this->menuModel->addMenu($image, $name, $price);
            }
    }
    
    public function deleteMenu($menuId) {
        $this->menuModel->deleteMenu($menuId);
        header('Location: /admin/menu');
    }
    
        public function displayUserMenu() {
        $menus = $this->menuModel->getAllMenus();
        include '../app/views/usermenu.php';
    }
    
    
}