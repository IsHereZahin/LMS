<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'file',
        'file_size',
        'is_premium'
    ];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Get the file URL
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file);
    }
}
