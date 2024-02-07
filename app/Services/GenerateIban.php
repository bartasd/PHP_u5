<?php

namespace App\Services;
use App\Models\Account;


class GenerateIban
{
    public static function getIBAN(){
        $accounts = Account::all();
        $ibans = $accounts->pluck('iban');
        $iban = null;
        do {
            $iban = "LT";
            $country = "2129";
            $randomEnd = "";
        
            for ($i = 0; $i < 18; $i++) {
                $randomEnd .= rand(0, 9);
            }
            // ORIGINAL
            $iban .= $randomEnd;
            // VALIDATING
            $randomEnd = str_split($randomEnd);
            $country .= array_shift($randomEnd);
            $country .= array_shift($randomEnd);
            $randomEnd = implode("", $randomEnd);
            $rotated = $randomEnd.$country;
            
            $mod = bcmod($rotated, "97");
        
            if ($mod !== "1") {
                $iban = null;
            }
        } while ($ibans->contains($iban) || $iban == null);
        return $iban;
    }
}
