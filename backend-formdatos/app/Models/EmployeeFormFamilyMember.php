<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeFormFamilyMember extends Model
{
    protected $fillable = [
        'employee_form_id',
        'full_name',
        'dni',
        'age',
        'sex_id',
        'relationship_id',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    public function employeeForm(): BelongsTo
    {
        return $this->belongsTo(EmployeeForm::class);
    }

    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(FamilyRelationship::class, 'relationship_id');
    }
}
