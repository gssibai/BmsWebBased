<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table="country";
    protected $fillable = ['country_code', 'country_name'];
public function country(){
    return $this->belongsTo(Country::class);
}
}
