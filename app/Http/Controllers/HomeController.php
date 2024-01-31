<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
    }

    public function start(){
        return view('start', [
            'page' => "start"
        ]);
    }
    
    public function accounts(){
        $height = session('height', 0);
        return view('accounts', [
            'height' => $height,
            'page' => "accounts"
        ]);
    }
    
    public function height(Request $request){
        session(['height' => $request->vpHeight]);
        return redirect()->route('accounts');
    }
    
    public function add(){
        return view('start', [
            'page' => "add"
        ]);
    }
    
    public function transfer(){
        return view('start', [
            'page' => "transfer"
        ]);
    }


}
