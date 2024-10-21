<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
class userController extends Controller
{
    public function userList(){
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('users.userIndex',compact('users'));
    }
}
