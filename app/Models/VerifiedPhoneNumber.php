<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifiedPhoneNumber extends Model
{
    use HasFactory;

    protected $table = 'verified_phone_numbers';

    protected $fillable = [
        'phone',
    ];
}
