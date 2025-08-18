<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(){
       return view('backend.dashboard');
    }
    public function profile(){
       return view('backend.user.profile');
    }
}
