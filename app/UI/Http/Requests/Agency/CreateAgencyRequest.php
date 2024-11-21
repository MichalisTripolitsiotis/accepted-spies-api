<?php

declare(strict_types=1);

namespace App\UI\Http\Requests\Agency;

use App\Application\Agency\DTOs\CreateAgencyData;
use Illuminate\Foundation\Http\FormRequest;

class CreateAgencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:agencies,name',
            ],
        ];
    }

    /**
     * Transform validated data into CreateSpyData.
     */
    public function payload(): CreateAgencyData
    {
        return CreateAgencyData::make($this->validated());
    }
}
