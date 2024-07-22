<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'project_id',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class)->orderBy('rank');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
