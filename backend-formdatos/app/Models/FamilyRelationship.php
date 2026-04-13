<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyRelationship extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function familyMembers(): HasMany
    {
        return $this->hasMany(EmployeeFormFamilyMember::class, 'relationship_id');
    }
}
