<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Profile extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
 /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'profile';

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone_no',
        'email',
        // 'city_id',
        'permission',
        'status',
        'passport_no',
        'password',
        'updated_at',
        'created_at'
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
