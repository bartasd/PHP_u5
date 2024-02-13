<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Services\GenerateIban;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $ids = $clients->pluck('id');

        forEach($ids as $id){
            $randNo = rand(3,7);
            for($i = 0; $i < $randNo; $i++){
                DB::table('accounts')->insert([
                    'owner_id' => $id,
                    'iban' => GenerateIban::getIBAN(),
                    'balance' => rand(1000,7000)
                ]); 
            }
        }
    }
}
