<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployeeForm extends Model
{
    protected $fillable = [
        'full_name',
        'dni',
        'ruc',
        'sex_id',
        'marital_status_id',
        'birth_date',
        'birth_place',
        'has_disability',
        'conadis_rui',
        'address',
        'reference',
        'district',
        'province',
        'department',
        'cellphone',
        'personal_email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'profession',
        'current_position',
        'dependency_id',
        'current_dependency',
        'contract_resolution_number',
        'employment_start_date',
        'labor_regime_id',
        'labor_condition',
        'pension_regime_id',
        'airshsp_code',
        'institutional_email',
        'has_labor_link',
        'labor_end_date',
        'is_parent',
        'status',
        'submitted_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'has_disability' => 'boolean',
        'employment_start_date' => 'date',
        'has_labor_link' => 'boolean',
        'labor_end_date' => 'date',
        'is_parent' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }

    public function maritalStatus(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function laborRegime(): BelongsTo
    {
        return $this->belongsTo(LaborRegime::class);
    }

    public function pensionRegime(): BelongsTo
    {
        return $this->belongsTo(PensionRegime::class);
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(EmployeeFormFamilyMember::class);
    }

    public function dependency(): BelongsTo
    {
        return $this->belongsTo(Dependency::class);
    }
}
