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
        session(['message' => "An account: {$info['iban']} has been created."]);
        session(['type' => 'success']);
        Account::create($info);
        return redirect()->route('clients-show', ['client' => $client, 'page' => $page]);
    }

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
        $byPass = false;
        if($request->byPass === "true"){
            $byPass = true;
        }
        if($request->ammount > 1000 && $byPass == false){
            return redirect()->route('accounts-getModalManual', ['ammount' => $request->ammount, 'account' => $account, 'action' => $action, 'client' => $client, 'page' => $page, 'iban' => $account->iban ]);
        }
        if($action == "plus"){
            $account->balance = $account->balance + $request->ammount;
            session(['message' => "An ammount of {$request->ammount} EUR has been added to selected account."]);
            session(['type' => 'success']);
            $account->update();
        }
        else{
            if($account->balance >= $request->ammount){
                $account->balance = $account->balance - $request->ammount;
                session(['message' => "An ammount of {$request->ammount} EUR has been taken away from selected account."]);
                session(['type' => 'success']);
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
            session(['message' => "A clients: {$client->name} {$client->surname} account: {$account->iban} has been deleted."]);
            session(['type' => 'success']);
            $account->delete();
        }
        else{
            session(['message' => "A clients: {$client->name} {$client->surname} account: {$account->iban} cannot be deleted because it's not empty."]);
            session(['type' => 'error']);
        }
        return redirect()->route('clients-show', compact(['client','page']));
    }
 
    public function transfer(){
        return view('accounts.transfer', [
            'combo' =>  Account::all()->sortBy('owner_id')->values()
        ]);
    }

    public function transferFunds(Request $request){ 
        $byPass = false;
        if($request->byPass === "true"){
            $byPass = true;
        }
        $fromIBAN =  $request->transferFromSelect;
        $toIBAN   =  $request->transferToSelect;
        $ammount = $request->ammount;
        if($ammount > 1000 && $byPass == false){
            return redirect()->route('accounts-getModalTransfer', ['ammount' => $ammount, 'iban1' => $fromIBAN, 'iban2' => $toIBAN ]);
        }
        if($fromIBAN == $toIBAN ){
            session(['message' => "You cannot transfer money to the same account."]);
            session(['type' => 'error']);
            return redirect()->route('accounts-transfer');
        }
        if($ammount <= 0 ){
            session(['message' => "You cannot transfer zero/negative ammounts, ammount: {$ammount} EUR"]);
            session(['type' => 'error']);
            return redirect()->route('accounts-transfer');
        }
        $donorAcc   = Account::all()->where('iban', $fromIBAN )->first();
        $patientAcc = Account::all()->where('iban', $toIBAN )->first();   
        if($donorAcc->balance < $ammount){
            session(['message' => "You cannot transfer funds due to insufficient funds: {{$donorAcc->balance}} EUR < {{$ammount}} EUR"]);
            session(['type' => 'error']);
            return redirect()->route('accounts-transfer');
        }
        session(['message' => "Funds: {{$ammount}} EUR transfered from: {{$fromIBAN}} to: {{$toIBAN}}"]);
        session(['type' => 'success']);
        $donorAcc->balance -= $ammount;
        $patientAcc->balance += $ammount;
        $donorAcc->update();
        $patientAcc->update();
        return redirect()->route('accounts-transfer');
    }

    public function deductTaxes(Request $request){ 
        $byPass = false;
        if($request->byPass === "true"){
            $byPass = true;
        }
        $tax = $request->ammount;
        if($tax > 1000 && $byPass == false){
            return redirect()->route('accounts-getModalTax', $tax);
        }
        if($tax <= 0 ){
            session(['message' => "You cannot tax zero/negative taxes."]);
            session(['type' => 'error']);
            return redirect()->route('accounts-transfer');
        }
        $allAccs = Account::all()->groupBy('owner_id')->map(function ($collection) {
            return $collection->random();
        });
        session(['message' => "All clients have been taxed with: {{$tax}} EUR tax."]);
        session(['type' => 'success']);
        foreach ($allAccs as $acc) {
            $acc->balance -= $tax;
            $acc->update();
        }
        return redirect()->route('accounts-transfer');
    }

    public function getModalTax($tax){ 
        return view('accounts.modal', [
            'type' => 'tax',
            'tax' =>  $tax,
        ]);
    }
    public function getModalTransfer($ammount, $iban1, $iban2){ 
        return view('accounts.modal', [
            'type'    => 'transfer',
            'ammount' =>  $ammount,
            'iban1'  =>  $iban1,
            'iban2' =>  $iban2
        ]);
    }
    public function getModalManual($ammount, $account, $action, $client, $page, $iban){ 
        return view('accounts.modal', [
            'type'    =>  'manual',
            'account' =>  $account,
            'action'  =>  $action,
            'ammount' =>  $ammount,
            'client'  =>  $client,
            'page'    =>  $page,
            'iban'    =>  $iban
        ]);
    }
}