<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityImport extends Model
{
    protected $fillable = [
        'uploaded_by',
        'file_name',
        'total_rows',
        'valid_rows',
        'invalid_rows',
        'processed_rows',
        'classified_rows',
        'review_required_rows',
        'unclassified_rows',
        'status',
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'import_id');
    }
}