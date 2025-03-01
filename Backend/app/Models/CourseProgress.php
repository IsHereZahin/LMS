<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    use HasFactory;

    protected $table = 'course_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'completed_lessons',
        'progress_percentage'
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that the progress belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
