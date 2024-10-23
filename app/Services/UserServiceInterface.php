<?php

namespace App\Services;

interface UserServiceInterface {
    public function listUsers();
    public function addUser(array $data);
    public function updateUser(int $id, array $data);
    public function deleteUser(int $id);
    public function restoreUser(int $id);
    public function getTrashedUsers();
    public function forceDeleteUser(int $id);
}