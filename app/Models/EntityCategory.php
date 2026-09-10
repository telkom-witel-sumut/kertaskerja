<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntityCategory extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(EntityCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(EntityCategory::class, 'parent_id');
    }

    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'category_id');
    }
    public function activityEntities()
    {
        return $this->hasMany(ActivityEntity::class, 'category_id');
    }
    
}