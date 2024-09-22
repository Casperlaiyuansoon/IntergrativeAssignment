<?php
interface UserActions
{
    public function addUser($username, $email, $phone_number, $password, $status);
    public function addAdmin($username, $email, $phone_number, $password, $role);
    public function deleteUser($user_id);
    public function deleteAdmin($admin_id);
    public function updateUser($id, $username, $email, $phone_number, $status);
    public function updateAdmin($id, $username, $email, $phone_number, $role);
    public function getAllUsers();
    public function getAllAdmins();
    public function searchUsers($query);
    public function searchAdmins($query);
    public function getUserById($id);
    public function getAdminById($id);
}