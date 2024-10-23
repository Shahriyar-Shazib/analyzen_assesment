<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Auth;
use App\Services\UserServiceInterface;

class userController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService) {
        $this->userService = $userService;
    }

    public function userList(){
        // $users = User::where('id', '!=', Auth::user()->id)->get(); //this is for without service class

        $users = $this->userService->listUsers();
        return view('users.userIndex',compact('users'));
    }
    public function userSave(StoreUserRequest $request){
        if (!Auth::check()) return redirect()-> route('login');

        // $request->validate([
        //     'name' => 'required | string',
        //     'email' => 'required | email | unique:users',
        //     'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            
        // ], [
        //     'name.required' => 'Please enter your name !',
        //     'name.string' => 'Only alphabets, numbers & special characters are allowed. Must be a string !',
        //     'email.required' => 'Please enter your email !',
        //     'email.email' => 'Please enter a valid email !',
        //     'email.unique' => 'This email already exist !',
        //     'picture.image' => 'The uploaded file must be an image.',
        //     'picture.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        //     'picture.max' => 'The image may not be greater than 2MB.',
            
        // ]);
        
        $this->userService->addUser($request->validated());//with service

        return response()->json(['success' => 'Date saved successfully.']);

        //here database data entry without service 

        // $file_location = null; 

        // if ($request->hasFile('picture')) {
        //     $file = $request->file('picture');
        //     $file_location = $file->store('pro_picture', 'public');
        // }

        // $userId = User::insert([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'picture' =>  $file_location,
        // ]);

    }

    public function userEdit(Request $request){

        $this->userService->updateUser($request->user_id, $request->all());//with service

        return response()->json(['success' => 'Data saved successfully.']); // Return success response

        //here database data update without service 
        // $user = User::find($request->user_id);
        // if ($user) {
        //     if ($request->hasFile('picture')) {
        //         $file = $request->file('picture');
        //         $file_location = $file->store('pro_picture', 'public');
        //         $user->picture = $file_location; 
        //     }
        //     $user->name = $request->name; 
        //     $user->email = $request->email; 
        //     $user->update();
    
        //     return response()->json(['success' => 'Data saved successfully.']); // Return success response
        // } else {
        //     return response()->json(['danger' => 'Data can\'t be saved.']);
        // }

       
    }
    public function userDelete($id){

        $this->userService->deleteUser($id);//with service

        return redirect()->back()->with(['danger' => 'Date Deleted successfully.']);

        //here database data delete without service 
        // $user = User::find($id);
        // if($user){
        //     $user->delete();
        //     return redirect()->back()->with(['danger' => 'Date Deleted successfully.']);
        // }
        // else{
        //     return redirect()->back()->with(['danger' => 'something wrong happen.']);
        // }
    }
    public function deletedUserList(){
        
        // $users = User::onlyTrashed()->get();//here database getting data without service 

        $users = $this->userService->getTrashedUsers();

        return view('users.deletedUserIndex',compact('users'));
    }
    public function restoreUser($id){

        $users = $this->userService->restoreUser($id);

        return redirect()->route('user.list')->with('success', 'User restored successfully.');

        //here database getting data without service 

        // $user = User::withTrashed()->find($id);
        // if ($user) {
        //     $user->restore();
        //     return redirect()->route('user.list')->with('success', 'User restored successfully.');
        // } else {
        //     return redirect()->back()->with('error', 'User not found.');
        // }
    
    }
    public function userForceDelete($id)
    {
        $users = $this->userService->forceDeleteUser($id);

        return redirect()->route('deleted.user.list')->with('success', 'User permanently deleted.');

        // $user = User::withTrashed()->find($id);
        // if ($user) {
        //     $user->forceDelete(); // Permanently delete the user
        //     return redirect()->route('deleted.user.list')->with('success', 'User permanently deleted.');
        // } else {
        //     return redirect()->back()->with('error', 'User not found.');
        // }
    }
}
