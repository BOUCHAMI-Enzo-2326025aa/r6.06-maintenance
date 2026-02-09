<?php

namespace App\Models;

use App\Models\Competition;
use App\Models\EpreuveRegistrationMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Epreuve extends Model
{
    protected $table = 'epreuves';

    protected $fillable = [
        'competition_id',
        'name',
        'min_team_size',
    ];

    protected $casts = [
        'min_team_size' => 'integer',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function registrationModes(): HasMany
    {
        return $this->hasMany(EpreuveRegistrationMode::class, 'epreuve_id');
    }
}
