<?php

namespace App\Services;

use App\Models\User;
use App\Events\UserAddressSaved;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserService implements UserServiceInterface {

    public function listUsers() {
        return User::where('id', '!=', Auth::user()->id)->get();
    }

    public function addUser($data) {
        // return $data['name'] ;
         $file_location = null; 

        if ($data['picture']) {
            $file = $data['picture'];
            $file_location = $file->store('pro_picture', 'public');
        }

        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'picture' =>  $file_location,
        ]);
        $address = $data['address'];
        event(new UserAddressSaved($user, $address));
        return $user;
    }

    public function updateUser($id, $data) {
     
        $user = User::find($data['user_id']);

        if ($data['picture']) {
            $file = $data['picture'];
            $file_location = $file->store('pro_picture', 'public');
            $user->picture = $file_location; 
        }

        $user->name = $data['name']; 
        $user->email = $data['email']; 
        $user->update();

        $address = $data['address'];
        event(new UserAddressSaved($user, $address));
        
        return null;
    }

    public function deleteUser($id) {
        $user = User::find($id);

        if($user){
            $user->delete();  
        }

        return false;
    }

    public function getTrashedUsers() {
       
        return User::onlyTrashed()->get();
    }

    public function restoreUser($id) {

        $user = User::withTrashed()->find($id);

        if ($user) {
            $user->restore();
        }

        return false;
    }

    public function forceDeleteUser($id) {
        
        $user = User::withTrashed()->find($id);

        if ($user) {
            $user->forceDelete(); // Permanently delete the user
        }

        return false;
    }
}

