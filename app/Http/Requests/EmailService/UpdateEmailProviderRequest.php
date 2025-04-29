<?php

namespace App\Http\Requests\EmailService;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailProviderRequest extends FormRequest
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
        $emailProviderId = $this->route('email_provider')->id;
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:email_providers,slug,' . $emailProviderId,
            'api_key' => 'required|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'base_url' => 'nullable|string',
            'from_email' => 'required|email'
        ];
    }

    /**
     * Validation messages
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Name must be string',
            'name.required' => 'Name is required',
            'slug.string' => 'Slug must be string',
            'slug.required' => 'Slug is required',
            'slug.unique' => 'Slug must be unique',
            'api_key.string' => 'API key must be string',
            'api_key.required' => 'API key is required',
            'username.string' => 'Username must be string',
            'password.string' => 'Password must be string',
            'base_url.string' => 'Base url must be string',
            'from_email.required' => 'From email is required',
            'from_email.email' => 'From email must be a valid address',
        ];
    }
}
