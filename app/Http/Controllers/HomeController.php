<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    //{
        //$this->middleware('auth');
    //}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latestNews = DB::table('news')->latest('created_at')->limit(4)->get();
        $departments = DB::table('departments')->get();
        return view('welcome', [
            'latestNews' => $latestNews,
            'departments' => $departments
        ]);
    }
}
