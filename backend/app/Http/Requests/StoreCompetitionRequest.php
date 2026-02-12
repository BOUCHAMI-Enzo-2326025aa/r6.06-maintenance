<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreCompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'championnat_id' => ['required', 'integer', 'exists:championnats,id'],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['sometimes', 'required', 'string', 'max:20'],
        ];
    }
}
