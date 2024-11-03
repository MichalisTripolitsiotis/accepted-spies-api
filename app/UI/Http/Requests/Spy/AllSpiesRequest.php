<?php

declare(strict_types=1);

namespace App\UI\Http\Requests\Spy;

use App\Domain\Common\DTOs\QueryParametersDTO;
use Illuminate\Foundation\Http\FormRequest;

class AllSpiesRequest extends FormRequest
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
            'filters.*' => 'nullable',
            'sorting.*' => 'nullable',
            'filters.name' => 'string|nullable',
            'filters.surname' => 'string|nullable',
            'filters.age_min' => 'integer|nullable',
            'filters.age_max' => 'integer|nullable|gte:filters.age_min',
            'filters.exact_age' => 'integer|nullable',
            'sorting.full_name' => 'in:asc,desc|nullable',
            'sorting.date_of_birth' => 'in:asc,desc|nullable',
            'sorting.date_of_death' => 'in:asc,desc|nullable',
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1',
        ];
    }

    /**
     * Transform validated data into QueryParametersDTO.
     */
    public function payload(): QueryParametersDTO
    {
        return QueryParametersDTO::make($this->validated());
    }
}
