<?php

declare(strict_types=1);

namespace App\UI\Http\Requests\Spy;

use App\Application\Spy\DTOs\CreateSpyData;
use App\Domain\Spy\ValueObjects\SpyAgency;
use App\Infrastructure\Laravel\Models\SpyModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSpyRequest extends FormRequest
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
            ],
            'surname' => [
                'required',
                'string',
                'max:255',
                $this->uniqueNameSurnameRule(),
            ],
            'agency' => [
                'required',
                'string',
                Rule::in(SpyAgency::values()),
            ],
            'country' => [
                'required',
                'string',
                'max:255',
            ],
            'date_of_birth' => [
                'required',
                'date',
            ],
            'date_of_death' => [
                'nullable',
                'date',
                'after:date_of_birth',
            ],
        ];
    }

    /**
     * Custom rule to enforce unique combination of name and surname.
     */
    private function uniqueNameSurnameRule(): \Closure
    {
        return function ($attribute, $value, $fail) {
            $exists = SpyModel::where('name', $this->input('name'))
                ->where('surname', $this->input('surname'))
                ->exists();

            if ($exists) {
                $fail('A spy with the same name and surname already exists.');
            }
        };
    }

    /**
     * Transform validated data into CreateSpyData.
     */
    public function payload(): CreateSpyData
    {
        return CreateSpyData::make($this->validated());
    }
}
