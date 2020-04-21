<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Role::create(['name' => 'root']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'doctor']);
        Role::create(['name' => 'patient']);

        return view('home');
    }
}
