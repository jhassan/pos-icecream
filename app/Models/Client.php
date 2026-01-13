<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'company_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Optional relation
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
