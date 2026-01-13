<?php

namespace App\Http\Requests\Auth;

use App\Enums\CivilStatusEnum;
use App\Enums\Gender;
use App\Enums\IdType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
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
        $rules = [
            'user_type' => ['required', 'in:farmer,investor,partner'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:25', 'unique:users,phone_number'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'birthday' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'gender' => ['required', new Enum(Gender::class)],
            'civil_status' => ['required', new Enum(CivilStatusEnum::class)],
            'address' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Farmer-specific rules
        if ($this->input('user_type') === 'farmer') {
            $rules = array_merge($rules, [
                'farming_background' => ['nullable', 'string', 'max:2000', 'required_if:familiarity_tree_cultivation,true'],
                'years_of_farming' => ['nullable', 'integer', 'min:0', 'max:100'],
                'familiarity_tree_cultivation' => ['required', 'boolean'],
            ]);
        }

        // Investor & Partner-specific rules
        if (in_array($this->input('user_type'), ['investor', 'partner'], true)) {
            $rules = array_merge($rules, [
                'id_type' => ['required', new Enum(IdType::class)],
                'id_front' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
                'id_back'  => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
            ]);
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'familiarity_tree_cultivation' => 'tree cultivation familiarity',
            'civil_status' => 'civil status',
            'id_front' => 'ID front image',
            'id_back' => 'ID back image',
        ];
    }

    public function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower($this->input('email')),
            ]);
        }

        if ($this->has('familiarity_tree_cultivation')) {
            $this->merge([
                'familiarity_tree_cultivation' =>
                    filter_var($this->familiarity_tree_cultivation, FILTER_VALIDATE_BOOLEAN),
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
