<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreChampionnatRequest extends FormRequest
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
        ];
    }
}
