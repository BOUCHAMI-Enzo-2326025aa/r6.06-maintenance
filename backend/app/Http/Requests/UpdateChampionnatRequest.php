<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateChampionnatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sport_id' => ['sometimes', 'required', 'integer', 'exists:sports,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'lieu' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
