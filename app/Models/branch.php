<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    use HasFactory;

  protected
  $table = 'branch';
  
  protected
  $fillable =[
    'branch_id',
    'branch_name',
    'address',
    'city_id',
    'zip_code',
    'manager_id',
  ];
  public function city(){
    return $this->belongsTo(City::class);
  }
}
