<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Competition extends Model
{
    protected $table = 'competitions';

    protected $fillable = [
        'championnat_id',
        'name',
        'status',
    ];

    public function championnat(): BelongsTo
    {
        return $this->belongsTo(Championnat::class, 'championnat_id');
    }

    public function epreuves(): HasMany
    {
        return $this->hasMany(Epreuve::class, 'competition_id');
    }
}
