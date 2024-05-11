<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'student_id' => ['required', 'integer'],
            'gender' => ['required', 'string'],
            'blood' => ['required', 'string'],
            'phone_number' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'class_id' => ['required', 'integer', Rule::exists('classes', 'id')],
            'section_id' => ['required', 'integer', Rule::exists('sections', 'id')],
            'date_of_birth' => ['required', 'date'],
            'parent_name' => ['required', 'string'],
            'parent_phone_number' => ['required', 'integer'],
            'parent_email' => ['required', 'email'],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'student_id' => $input['student_id'],
            'gender' => $input['gender'],
            'role' => User::ROLE_DEFAULT,
            'blood' => $input['blood'],
            'phone_number' => $input['phone_number'],
            'address' => $input['address'],
            'class_id' => $input['class_id'],
            'section_id' => $input['section_id'],
            'date_of_birth' => $input['date_of_birth'],
            'parent_name' => $input['parent_name'],
            'parent_phone_number' => $input['parent_phone_number'],
            'parent_email' => $input['parent_email'],
        ]);
    }
}
