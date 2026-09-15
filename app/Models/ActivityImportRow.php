<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityImportRow extends Model
{
    protected $fillable = [
        'import_id',
        'source_row',
        'source_id',
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
        'validation_status',
        'validation_errors',
        'classification_status',
        'nama_pic_1',
        'jabatan_pic_1',
        'peran_pic_1',
    ];

    protected $casts = [
        'validation_errors' => 'array',
        'activity_start_date' => 'datetime',
        'activity_end_date' => 'datetime',
        'created_at_source' => 'datetime',
    ];

    public function import(): BelongsTo
    {
        return $this->belongsTo(ActivityImport::class, 'import_id');
    }
}