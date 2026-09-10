<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityEntity extends Model
{
    protected $fillable = [
        'activity_id',
        'category_id',
        'entity_id',
        'match_score',
        'match_method',
    ];

    protected $casts = [
        'match_score' => 'decimal:4',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function category()
{
    return $this->belongsTo(EntityCategory::class);
}

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }
}