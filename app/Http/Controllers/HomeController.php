<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Account;

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

    public function home(){
        $accounts = Account::all();
        $clients = Client::all();
        return view('home', [
            'clients' => $clients,
            'accounts' => $accounts
        ]);
    }

    public function signout(){
        return view('home');
    }


}
