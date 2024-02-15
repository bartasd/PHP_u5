<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'iban',
        'balance'
    ];

    public function clients(){
        return $this->belongsTo(Client::class);
    }
}
