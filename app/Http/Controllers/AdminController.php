<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Dashboard placeholder
        return view('admin.dashboard');
    }

    // Minimal user resource methods if used as a resource controller
    public function indexUsers()
    {
        return view('admin.users.index');
    }
}
