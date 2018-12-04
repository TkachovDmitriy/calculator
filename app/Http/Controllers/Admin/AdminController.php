<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//use App\Role;

class AdminController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        return view('admin/dashboard',['user' => $user]);
    }












}