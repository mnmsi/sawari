<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_or_email',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
