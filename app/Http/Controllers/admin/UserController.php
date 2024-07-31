<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('user_type','!=','admin')->get();
        return view('admin.users.index',compact('users'));
    }

}
