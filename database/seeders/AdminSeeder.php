<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->create([
            'name'=>'admin',
            'user_type'=>'admin',
            'email'=>'mohamed@gmail.com',
            'phone'=>'01011642731',
            'password'=>Hash::make('11111111')
        ]);
    }
}
