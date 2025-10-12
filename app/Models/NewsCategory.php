<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the news for the category.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }
}
