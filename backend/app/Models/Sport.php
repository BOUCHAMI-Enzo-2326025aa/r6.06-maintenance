<?php

namespace App\Models;

use App\Models\Championnat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Sport extends Model
{
    protected $table = 'sports';

    protected $fillable = [
        'name',
        'type',
    ];

    public function championnats(): HasMany
    {
        return $this->hasMany(Championnat::class, 'sport_id');
    }
}
