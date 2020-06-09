<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->middleware('auth');
        if(Auth::user()->Type==1)
        {
        return view('home');
        }
        return view('UserPage');

    }
    public function register()
    {

        $data['title'] = '404';
        $data['name'] = 'Page not found';
        return response()
            ->view('errors.404',$data,404);
    }
    public function registerId()
    {


        return view('auth/register');

    }
}
