<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'duration',
        'youtube_video_id',
        'is_premium'
    ];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
}

