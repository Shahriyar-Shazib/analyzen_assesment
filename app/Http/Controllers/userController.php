<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
class userController extends Controller
{
    public function userList(){
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('users.userIndex',compact('users'));
    }
    public function userSave(Request $request){
        if (!Auth::check()) return redirect()-> route('login');
        $request->validate([
            'name' => 'required | string',
            'email' => 'required | email | unique:users',
            
        ], [
            'name.required' => 'Please enter your name !',
            'name.string' => 'Only alphabets, numbers & special characters are allowed. Must be a string !',
            'email.required' => 'Please enter your email !',
            'email.email' => 'Please enter a valid email !',
            'email.unique' => 'This email already exist !',
            
        ]);


        if ($request->hasFile('picture')) {
            $file = $request->file('picture');

            $filePath = $file->store('pro_picture', 'public');  // Store in 'storage/app/public/uploads'
        
            $fileName = $file->getClientOriginalName();  // Original file name
            $fileExtension = $file->getClientOriginalExtension();  // File extension (pdf)
            $file_location = $filePath .''.$fileName;
            
        }

        $userId = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'picture' =>  $file_location,
        ]);

        return redirect()->back();

    }
}
