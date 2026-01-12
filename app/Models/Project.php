<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- ADD THIS
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory; // <--- ADD THIS inside the class

    protected $fillable = ['name', 'slug', 'description', 'status', 'user_id'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}