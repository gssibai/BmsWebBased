<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';
    protected $fillable = ['currency_id','currency_code', 'currency_name'];
    public function country(){
        return $this->belongsTo(Country::class);
    }
    
}
