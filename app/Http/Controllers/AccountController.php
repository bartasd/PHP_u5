<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Client;
use App\Services\GenerateIban;

class AccountController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Client $client, $page)
    {
        $info = [];
        $info['owner_id'] = $client->id;
        $info['iban'] = GenerateIban::getIBAN();
        $info['balance'] = 0;
        Account::create($info);
        return redirect()->route('clients-show', ['client' => $client, 'page' => $page]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Client $client, Account $account, $action, $page)
    {
        return view('accounts.edit', [
            'account' => $account,
            'client' => $client,
            'action' => $action,
            'page' => $page
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Client $client, Account $account, $action, $page)
    {
        if($action == "plus"){
            $account->balance = $account->balance + $request->ammount;
        }
        else{
            $account->balance = $account->balance - $request->ammount;
        }
        $account->update();
        return redirect()->route('clients-show', ['client' => $client, 'page' => $page]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account, Client $client, $page)
    {
        $account->delete();
        return redirect()->route('clients-show', ['client' => $client, 'page' => $page]);
    }
}
