<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityClassificationReview extends Model
{
    protected $fillable = [
        'activity_id',
        'selected_activity_entity_id',
        'decision',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function selectedActivityEntity(): BelongsTo
    {
        return $this->belongsTo(ActivityEntity::class, 'selected_activity_entity_id');
    }
}