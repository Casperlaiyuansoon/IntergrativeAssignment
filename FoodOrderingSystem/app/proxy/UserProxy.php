<?php
include_once '../proxy/UserActions.php';
include_once '../model/UserAdminManager.php';
class UserProxy implements UserActions
{
    private $userAdminManager;
    private $role; 

    public function __construct($role)
    {
        $this->userAdminManager = new UserAdminManager();
        $this->role = $role;
    }

    public function addUser($username, $email, $phone_number, $password, $status)
    {
        if ($this->role === 'Admin') {
            return $this->userAdminManager->addUser($username, $email, $phone_number, $password, $status);
        } else {
            throw new Exception("Permission denied: You do not have access to add users.");
        }
    }

    public function addAdmin($username, $email, $phone_number, $password, $role)
    {
        if ($this->role === 'Admin') {
            return $this->userAdminManager->addAdmin($username, $email, $phone_number, $password, $role);
        } else {
            throw new Exception("Permission denied: You do not have access to add admins.");
        }
    }

    public function deleteUser($user_id)
    {
        if ($this->role === 'Admin') {
            return $this->userAdminManager->deleteUser($user_id);
        } else {
            throw new Exception("Permission denied: You do not have access to delete users.");
        }
    }

    public function deleteAdmin($admin_id)
    {
        if ($this->role === 'Admin') {
            return $this->userAdminManager->deleteAdmin($admin_id);
        } else {
            throw new Exception("Permission denied: You do not have access to delete admins.");
        }
    }

    public function updateUser($id, $username, $email, $phone_number, $status)
    {
        if ($this->role === 'Admin' || $this->role === 'Moderator') {
            return $this->userAdminManager->updateUser($id, $username, $email, $phone_number, $status);
        } else {
            throw new Exception("Permission denied: You do not have access to update users.");
        }
    }

    public function updateAdmin($id, $username, $email, $phone_number, $role)
    {
        if ($this->role === 'Admin' || $this->role === 'Moderator') {
            return $this->userAdminManager->updateAdmin($id, $username, $email, $phone_number, $role);
        } else {
            throw new Exception("Permission denied: You do not have access to update admins.");
        }
    }

    public function getAllUsers()
    {
        return $this->userAdminManager->getAllUsers(); // Accessible to all roles
    }

    public function getAllAdmins()
    {
        return $this->userAdminManager->getAllAdmins(); // Accessible to all roles

    }

    public function searchUsers($query)
    {
        return $this->userAdminManager->searchUsers($query); // Accessible to all roles
    }

    public function searchAdmins($query)
    {
        return $this->userAdminManager->searchAdmins($query); // Accessible to all roles
    }

    public function getUserById($id)
    {
        return $this->userAdminManager->getUserById($id); // Accessible to all roles
    }

    public function getAdminById($id)
    {
        return $this->userAdminManager->getAdminById($id); // Accessible to all roles
    }
}
