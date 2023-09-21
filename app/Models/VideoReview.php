<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video_url',
        'video_thumbnail',
    ];
}
