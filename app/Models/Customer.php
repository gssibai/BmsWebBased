<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
        'account_id',
        'profile_id',
    ];

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
