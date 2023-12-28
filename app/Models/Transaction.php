<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    protected $fillable = [
        'amount',
        'transaction_date',
        'transaction_type',
        'branch_id',
        'balance',
        'account_id',
        'description',
        'to_account_id'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
