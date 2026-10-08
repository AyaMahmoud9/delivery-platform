<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'username' => ['required', 'string', 'max:255'],

            'mobile' => [
                'required',
                'string',
                Rule::unique('users', 'mobile')->ignore($userId),
            ],

            'password' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'string',
                'min:8',
            ],

            'type' => [
                'required',
                Rule::in(['user', 'delivery', 'admin']),
            ],

            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'max:5120',
            ],
        ];
    }
}