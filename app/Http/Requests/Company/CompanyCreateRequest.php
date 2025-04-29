<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable',
            'workspace' => 'required',
            'domain' => 'nullable',
            'allowed_domains' => 'nullable|json',
        ];
    }

    function messages()
    {
        return [
            'name.required' => trans('validation.name_required'),
            'email.required' => trans('validation.email_required'),
            'password.required' => trans('validation.password_required'),
            'workspace.required' => trans('validation.workspace_required')
        ];
    }
}
