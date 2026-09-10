<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $fillable = [
        'import_id',
        'source_id',
        'source_row',
        'nik',
        'name',
        'role',
        'am_type',
        'division',
        'segment',
        'regional',
        'witel',
        'ca_name',
        'nipnas',
        'activity_start_date',
        'activity_end_date',
        'created_at_source',
        'label',
        'activity_type',
        'activity_notes',
        'classification_status',
    ];

    protected $casts = [
        'activity_start_date' => 'datetime',
        'activity_end_date' => 'datetime',
        'created_at_source' => 'datetime',
    ];

    public function import(): BelongsTo
    {
        return $this->belongsTo(ActivityImport::class, 'import_id');
    }

    public function activityEntities(): HasMany
    {
        return $this->hasMany(ActivityEntity::class);
    }

    public function entities(): BelongsToMany
    {
 return $this->belongsToMany(
        Entity::class,
        'activity_entities'
    )->withPivot([
        'category_id',
        'match_score',
        'match_method',
    ])->withTimestamps();
    }
}