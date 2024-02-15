<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoReview extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video_url',
        'video_thumbnail',
        'order_no',
        'status',
    ];
}
