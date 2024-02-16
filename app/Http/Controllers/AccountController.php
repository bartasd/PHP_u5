<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Client;
use App\Services\GenerateIban;
use Illuminate\Http\Request;

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

    public function update(UpdateAccountRequest $request, Client $client, Account $account, $action, $page)
    {
        if($action == "plus"){
            $account->balance = $account->balance + $request->ammount;
            $account->update();
        }
        else{
            if($account->balance >= $request->ammount){
                $account->balance = $account->balance - $request->ammount;
                $account->update();
            }
            else{
                // GENERATE MESSAGE THAT THE AMMOUNT CANNOT BE CONTRACTED
            }
        }
        return redirect()->route('clients-show', ['client' => $client, 'page' => $page]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account, Client $client, $page)
    {
        if($account->balance == 0){
            $account->delete();
        }
        else{
            //  IMPLEMENT MESSAGE - YOUR ACCOUNT HAS CASH IN IT/OR IS NEGATIVE...
        }
        return redirect()->route('clients-show', compact(['client','page']));
    }
 
    public function transfer(){
        return view('accounts.transfer', [
            'combo' =>  Account::all()->sortBy('owner_id')->values()
        ]);
    }

    public function transferFunds(Request $request){ 
        $fromIBAN =  $request->transferFromSelect;
        $toIBAN   =  $request->transferToSelect;
        $ammount = $request->ammount;
        if($fromIBAN == $toIBAN ){
            // show message that you cannot wire money to yourself
            return redirect()->route('accounts-transfer');
        }
        if($ammount <= 0 ){
            // show message that you cannot trasnfer zero or negative ammounts
            return redirect()->route('accounts-transfer');
        }
        $donorAcc   = Account::all()->where('iban', $fromIBAN )->first();
        $patientAcc = Account::all()->where('iban', $toIBAN )->first();   
        if($donorAcc->balance < $ammount){
            // show meesage that transfer cannot be done due to insufficient funds
            return redirect()->route('accounts-transfer');
        }
        $donorAcc->balance -= $ammount;
        $patientAcc->balance += $ammount;
        $donorAcc->update();
        $patientAcc->update();
        return redirect()->route('accounts-transfer');
    }

    public function deductTaxes(Request $request){ 
        $tax = $request->ammount;
        if($tax <= 0 ){
            // show message that you cannot tax zero or negative taxes
            return redirect()->route('accounts-transfer');
        }
        $allAccs = Account::all()->groupBy('owner_id')->map(function ($collection) {
            return $collection->random();
        });
        foreach ($allAccs as $acc) {
            $acc->balance -= $tax;
            $acc->update();
        }
        return redirect()->route('accounts-transfer');
    }
}