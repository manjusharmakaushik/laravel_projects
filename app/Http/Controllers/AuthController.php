<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('content.authentications.auth-login-basic');
    }
    public function checkAuth(){

        return view('content.dashboard.dashboards-analytics');
    }
}
