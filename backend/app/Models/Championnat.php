<?php

namespace App\Models;

use App\Models\Competition;
use App\Models\Sport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Championnat extends Model
{
    protected $table = 'championnats';

    protected $fillable = [
        'sport_id',
        'name',
    ];

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    public function competitions(): HasMany
    {
        return $this->hasMany(Competition::class, 'championnat_id');
    }
}
