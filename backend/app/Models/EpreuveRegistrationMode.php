<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class EpreuveRegistrationMode extends Model
{
    protected $table = 'epreuve_registration_modes';

    protected $fillable = [
        'epreuve_id',
        'mode',
    ];

    public function epreuve(): BelongsTo
    {
        return $this->belongsTo(Epreuve::class, 'epreuve_id');
    }
}
