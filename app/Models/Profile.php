<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class Profile extends Model
{
    protected $table = 'profile';

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone_no',
        'email',
        'city_id',
        'permission',
        'status',
        'passport_no',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function city()
    {
        return $this->belongsTo(City::class); // Assuming 'City' model exists
    }

    // Add custom getters and setters for sensitive fields like password

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
