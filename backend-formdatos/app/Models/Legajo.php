<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Legajo extends Model
{
    protected $fillable = [
        'employee_form_id',
        'legajo_number',
        'status',
        'opening_date',
        'closing_date',
        'physical_location',
        'digital_location',
        'dependency_id',
        'labor_regime_id',
        'position_name',
        'folios_total',
        'observations',
    ];

    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
    ];

    public function employeeForm(): BelongsTo
    {
        return $this->belongsTo(EmployeeForm::class);
    }

    public function dependency(): BelongsTo
    {
        return $this->belongsTo(Dependency::class);
    }

    public function laborRegime(): BelongsTo
    {
        return $this->belongsTo(LaborRegime::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(LegajoDocument::class);
    }
}