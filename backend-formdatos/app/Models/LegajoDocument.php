<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegajoDocument extends Model
{
    protected $fillable = [
        'legajo_id',
        'legajo_section_id',
        'document_name',
        'document_type',
        'document_number',
        'issue_date',
        'incorporation_date',
        'folios_start',
        'folios_end',
        'folios_count',
        'file_path',
        'original_file_name',
        'mime_type',
        'file_size',
        'is_sensitive',
        'verification_status',
        'observations',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'incorporation_date' => 'date',
        'is_sensitive' => 'boolean',
    ];

    public function legajo(): BelongsTo
    {
        return $this->belongsTo(Legajo::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(LegajoSection::class, 'legajo_section_id');
    }
}