<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user()->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $this->user()->id,
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $this->user()->id,
        ];
    }
}
