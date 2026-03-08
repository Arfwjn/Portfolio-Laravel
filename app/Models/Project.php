<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Model untuk tabel projects.
 * Mewakili satu proyek di portofolio.
 * Dilengkapi dengan scope query untukfilter data dan accessor URL thumbnail.
 */
class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'demo_url',
        'github_url',
        'tech_stack',
        'category',
        'sort_order',
        'is_featured',
        'is_published',
        'built_at',
    ];

    protected $casts = [
        'tech_stack'   => 'array',
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'built_at'     => 'date',
    ];

    /**
     * Scope: mengambil hanya proyek yang sudah dipublish.
     * Cara pakai: Project::published()->get()
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope: mengambil hanya proyek yang di-featured.
     * Cara pakai: Project::featured()->get()
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: mengurutkan berdasarkan sort_order, lalu berdasarkan built_at.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('built_at');
    }

    /**
     * Accessor: mendapatkan URL lengkap thumbnail proyek.
     * Mengembalikan null kalau belum ada gambar.
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->thumbnail
                ? asset('storage/' . $this->thumbnail)
                : null
        );
    }
}

