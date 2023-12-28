<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $fillable = [
        'job_title_id',
        'salary',
        'branch_id',
        'profile_id',
    ];

    public function jobTitle(){
        return $this->belongsTo(JobTitle::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
