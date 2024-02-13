<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Account;
use Illuminate\Http\Request;


class ClientController extends Controller
{

    public function showAll($page = 1){
        $accs = Account::all();
        $clients = Client::all();
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
        Client::create($request->all());
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
        $client->update($request->all());
        return redirect()->route('clients-show', ['client' => $client, 'page' => $page]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients-accounts');
    }
}
