<?php

namespace App\Http\Requests\Agent;

use App\Enums\CivilStatusEnum;
use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AgentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->farmer !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_type' => ['required', 'in:agent'],
            'first_name' => ['required', 'string', 'max:50'],
            'middle_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'birthday' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'gender' => ['required', new Enum(Gender::class)],
            'civil_status' => ['required', new Enum(CivilStatusEnum::class)],
            'address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'farmer_id' => [
                    'nullable',                 
                    'number',
                    'exists:farmers,id', 
                ],
        ];
    }

    public function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower($this->input('email')),
            ]);
        }

        if (is_array($this->birthday)) {
            $year = $this->birthday['year'] ?? now()->year;
            $month = $this->birthday['month'] ?? 1;
            $day = $this->birthday['day'] ?? 1;
            $this->merge([
                'birthday' => sprintf('%04d-%02d-%02d', $year, $month, $day),
            ]);
        }
    }
}
