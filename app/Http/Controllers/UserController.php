<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('content.users.user-list');
    }
    public function create(){
        return view('content.users.user-add');
    }
}
