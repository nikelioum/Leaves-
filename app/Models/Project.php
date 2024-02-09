<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'description',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
