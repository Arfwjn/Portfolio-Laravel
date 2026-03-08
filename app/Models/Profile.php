<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name','title','subtitle','bio',
        'experience_years','education','location',
        'email','phone',
        'github_url','linkedin_url','twitter_url','website_url','resume_url',
        'avatar','hero_image',
        'interests','is_open_to_work',
    ];

    protected $casts = [
        'interests'       => 'array',
        'is_open_to_work' => 'boolean',
    ];

    public static function getSingle(): ?static
    {
        return static::first();
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->hero_image ? asset('storage/' . $this->hero_image) : null;
    }
}