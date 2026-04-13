<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaritalStatus extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function employeeForms(): HasMany
    {
        return $this->hasMany(EmployeeForm::class);
    }
}
