<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::count(); 
        if($user == 0)
        {
            $user = new User();

            $user->name = 'admin';

            $user->email = 'admin@gmail.com';
            
            $user->password = Hash::make('11111111');

            $user->created_at = now();
            
            $user->updated_at = now();

            $user->save();
        }
    }
}
