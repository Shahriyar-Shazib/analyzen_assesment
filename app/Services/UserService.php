<?php

namespace App\Services;

use App\Models\User;
use Auth;

class UserService implements UserServiceInterface {
    public function listUsers() {
        return User::where('id', Auth::user()->id)->get();
    }

    public function addUser(array $data) {
        return User::create($data);
    }

    public function updateUser(int $id, array $data) {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function deleteUser(int $id) {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }

    public function restoreUser(int $id) {
        $user = User::withTrashed()->find($id);
        if ($user && $user->trashed()) {
            $user->restore();
            return true;
        }
        return false;
    }

    public function getTrashedUsers() {
        return User::onlyTrashed()->get();
    }

    public function forceDeleteUser(int $id) {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->forceDelete();
            return true;
        }
        return false;
    }
}

