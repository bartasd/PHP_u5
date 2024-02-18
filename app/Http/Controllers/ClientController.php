<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Services\IdValidator;

class ClientController extends Controller
{

    public function showAll($page = 1){
        $accs = Account::all();
        $clients = Client::all();

        // FILTERING
        if (session()->has('filter')) {
            $filter = session('filter');
            if($filter == "all"){
                $clients = Client::all();
            }
            else if($filter == "no_acc"){
                $clients = $clients->filter(function (Client $client) {
                    return $client->accounts()->count() == 0;
                })->values();
            }
            else if($filter == "empty_acc"){
                $clients = $clients->filter(function (Client $client) {
                    return $client->accounts()->where('balance', 0)->exists();
                })->values();
            }
            else if($filter == "non_empty_acc"){
                $clients = Client::all()->filter(function (Client $client) {
                    return $client->accounts()->sum('balance') > 0;
                })->values();
            }   
            else if ($filter == "negative_acc") {
                $clients = $clients->filter(function (Client $client) {
                    return $client->accounts()->where('balance', '<', 0)->exists();
                })->values();
            }
        }


        // SORTING
        if (session()->has('sorter')){
            $sortby = session('sortby');
            $mode = session('mode');
            if($mode == "a"){
                $clients = $clients->sortBy($sortby)->values();
            }
            else{
                $clients = $clients->sortByDesc($sortby)->values();
            }
        }
        else{
            $clients = $clients->sortBy('surname')->values();
        }


        return view('clients.accounts', [
            'clients' => $clients,
            'page' => $page,
            'accs' => $accs
        ]);
    }
    public function show(Client $client, $page ){
        $accs = Account::where('owner_id', $client->id)->get();
        return view('clients.show', [
            'client' => $client,
            'page' => $page,
            'accs' => $accs
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $validID = IdValidator::validateID($request->id_code);
        if(!$validID){
            session(['message' => "It seems your id: {$request->id_code} is invalid. Please try again."]);
            session(['type' => 'error']);
            return redirect()->route('clients-accounts');
        }
        if(Client::all()->pluck('id_code')->contains($request->id_code)){
            session(['message' => "It seems there already is a client with this ID. Please check your ID."]);
            session(['type' => 'error']);
            return redirect()->route('clients-accounts');
        }
        if(strlen($request->name) < 4 || strlen($request->surname) < 4){
            session(['message' => "Your name/surname is too short. Please try again."]);
            session(['type' => 'error']);
            return redirect()->route('clients-accounts');
        }
        Client::create($request->all());
        session(['message' => "A client: {$request->name} {$request->surname} has been created."]);
        session(['type' => 'success']);
        return redirect()->route('clients-accounts');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client, $page)
    {
        return view('clients.edit', [
            'client' => $client,
            'page' =>$page
        ]);
    }


    public function update(UpdateClientRequest $request, Client $client, $page)
    {
        session(['message' => "A client: {$client->name} {$client->surname} has been updated to: {$request->name} {$request->surname}."]);
        session(['type' => 'success']);
        $client->update($request->all());
        return redirect()->route('clients-show', ['client' => $client, 'page' => $page]);
    }

 
    public function destroy(Client $client)
    {
        $totalBalance = Account::where('owner_id', $client->id)->pluck('balance')->sum();
        if($totalBalance == 0){
            session(['message' => "A client: {$client->name} {$client->surname} has been deleted."]);
            session(['type' => 'success']);
            $client->delete();
            
        }
        else{
            session(['message' => "A client: {$client->name} {$client->surname} cannot be deleted because, it's accounts must be eqaul to zero."]);
            session(['type' => 'error']);
        }
        return redirect()->route('clients-accounts');
    }


    public function sortBy(Request $request)
    {
        session(['sorter' => 'true']);
        $sortby = null;
        $mode = null;
        $r = null;
        $fullSort = $request->sort;
        $r = explode("_", $fullSort); 
        if($fullSort == "id_code_a" || $fullSort == "id_code_d"){
            $sortby = "id_code";
            $mode = $r[2];
        }
        else{
            $sortby = $r[0];
            $mode = $r[1];
        }
        session(['sortby' => $sortby]);
        session(['mode' => $mode]);
        return $this->showAll();
    }

    public function filterBy(Request $request)
    {
        $filter = $request->filter;
        if($filter == "all"){
            session(['filter' => 'all']);
        }
        else if($filter == "no_acc"){
            session(['filter' => 'no_acc']);
        }
        else if($filter == "empty_acc"){
            session(['filter' => 'empty_acc']);
        }
        else if($filter == "non_empty_acc"){
            session(['filter' => 'non_empty_acc']);
        }   
        else if ($filter == "negative_acc") {
            session(['filter' => 'negative_acc']);
        }
        return $this->showAll();
    }
}