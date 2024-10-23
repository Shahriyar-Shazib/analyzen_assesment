<?php

namespace App\Services;

interface UserServiceInterface {
    public function listUsers();
    public function addUser($data);
    public function updateUser($id, $data);
    public function deleteUser($id);
    public function getTrashedUsers();
    public function restoreUser($id);
    public function forceDeleteUser($id);
}