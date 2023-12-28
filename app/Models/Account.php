<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $fillable =[
        'balance',
        'account_type',
        'currency_id',
        'customer_id',
    ];
    protected $with = ['currency', 'customer'];
    protected $casts = [
        'balance' => 'decimal:2',
    ];
    public function currency()
    {
        return $this->belongsTo(Currency::class); 
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class); 
}
}
