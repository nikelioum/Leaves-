<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }
}
