<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreChampionnatFullRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sport_id' => ['required', 'integer', 'exists:sports,id'],
            'name' => ['required', 'string', 'max:255'],
            'lieu' => ['sometimes', 'nullable', 'string', 'max:255'],

            // Au moins 1 compétition
            'competitions' => ['required', 'array', 'min:1'],
            'competitions.*.name' => ['required', 'string', 'max:255'],
            'competitions.*.status' => ['sometimes', 'string', 'max:20'],

            // Au moins 1 épreuve par compétition
            'competitions.*.epreuves' => ['required', 'array', 'min:1'],
            'competitions.*.epreuves.*.name' => ['required', 'string', 'max:255'],
            'competitions.*.epreuves.*.min_team_size' => ['sometimes', 'integer', 'min:1'],
            'competitions.*.epreuves.*.modes' => ['sometimes', 'array'],
            'competitions.*.epreuves.*.modes.*' => ['string', 'max:20'],
        ];
    }
}
