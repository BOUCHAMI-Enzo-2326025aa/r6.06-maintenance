<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreEpreuveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'competition_id' => ['required', 'integer', 'exists:competitions,id'],
            'name' => ['required', 'string', 'max:255'],
            'min_team_size' => ['sometimes', 'required', 'integer', 'min:1'],
            'modes' => ['sometimes', 'array'],
            'modes.*' => ['string', 'max:20'],
        ];
    }
}
