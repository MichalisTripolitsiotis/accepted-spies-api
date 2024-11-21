<?php

declare(strict_types=1);

namespace App\UI\Http\Requests\Agency;

use App\Domain\Common\DTOs\QueryParametersDTO;
use Illuminate\Foundation\Http\FormRequest;

class AllAgenciesRequest extends FormRequest
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
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $allowedKeys = ['page', 'per_page'];

        $unsupportedKeys = array_diff(array_keys($this->all()), $allowedKeys);

        if (! empty($unsupportedKeys)) {
            throw new \InvalidArgumentException('Unsupported parameter(s}: '.implode(', ', $unsupportedKeys));
        }
    }

    /**
     * Transform validated data into QueryParametersDTO.
     */
    public function payload(): QueryParametersDTO
    {
        return QueryParametersDTO::make($this->validated());
    }
}
