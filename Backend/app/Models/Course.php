<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'language',
        'certificate',
        'what_you_learn',
        'price',
        'discount',
        'discount_ends_at',
        'thumbnail',
        'duration',
        'level',
        'publish'
    ];

    protected $casts = [
        'certificate' => 'boolean',
        'what_you_learn' => 'array',
        'price' => 'float',
        'discount' => 'float',
        'discount_ends_at' => 'date',
        'publish' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    // Get the thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        return asset('storage/' . $this->thumbnail);
    }

    // Calculate discounted price
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount && $this->discount > 0 && (!$this->discount_ends_at || $this->discount_ends_at >= now())) {
            return $this->price - $this->discount;
        }

        return $this->price;
    }

    public function progress()
    {
        return $this->hasOne(CourseProgress::class, 'course_id', 'id')->where('user_id', auth()->id());
    }
}

