<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
    protected $fillable = ['state_code', 'state_name', 'country_id'];
public function country(){
    return $this->belongsTo(Country::class);
}
}
