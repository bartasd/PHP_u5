<?php

namespace App\Services;

class IdValidator
{
    public static function validateID($id_code){
        if (strlen( $id_code) === 11 &&  $id_code[0] >= 1 &&  $id_code[0] <= 6) {
            if (checkdate(substr( $id_code, 3, 2), substr( $id_code, 5, 2), substr( $id_code, 1, 2))) {
                $s =  $id_code[0] * 1 +  $id_code[1] * 2 +  $id_code[2] * 3 +  $id_code[3] * 4 +  $id_code[4] * 5 +  $id_code[5] * 6 +  $id_code[6] * 7 +  $id_code[7] * 8 +  $id_code[8] * 9 +  $id_code[9] * 1;
                if ($s % 11 === 10) {
                    $s =  $id_code[0] * 3 +  $id_code[1] * 4 +  $id_code[2] * 5 +  $id_code[3] * 6 +  $id_code[4] * 7 +  $id_code[5] * 8 +  $id_code[6] * 9 +  $id_code[7] * 1 +  $id_code[8] * 2 +  $id_code[9] * 3;
                    if  ($s % 11 ==  $id_code[10])
                        return true;
                } elseif ($s % 11 ==  $id_code[10]) {
                    return true;
                }
            }
        }
        // GENERATE MESSAGE: "Cannot create account. Please, check your id code."
        return false;
    }
}
