<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreSportRequest extends FormRequest
{
    public const TYPE_INDIVIDUEL = 'individuel';
    public const TYPE_EQUIPE = 'equipe';
    public const TYPE_RELAIS = 'relais';
    public const TYPE_INDIVIDUEL_EQUIPE = 'individuel_equipe';

    public static function allowedTypes(): array
    {
        return [
            self::TYPE_INDIVIDUEL,
            self::TYPE_EQUIPE,
            self::TYPE_RELAIS,
            self::TYPE_INDIVIDUEL_EQUIPE,
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['sometimes', 'string', Rule::in(self::allowedTypes())],
        ];
    }
}
