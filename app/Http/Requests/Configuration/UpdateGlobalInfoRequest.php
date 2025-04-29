<?php

namespace App\Http\Requests\Configuration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGlobalInfoRequest extends FormRequest
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
            'domain_admin_portal' => 'required|string',
            'company_http_protocol' => 'required|string',
            'support_email' => 'required|string',
            'support_telephone' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'domain_admin_portal.string' => __('validation.custom.configuration.domain_admin_portal.string'),
            'domain_admin_portal.required' => __('validation.custom.configuration.domain_admin_portal.required'),
            'company_http_protocol.string' => __('validation.custom.configuration.company_http_protocol.string'),
            'company_http_protocol.required' => __('validation.custom.configuration.company_http_protocol.required'),
            'support_email.string' => __('validation.custom.configuration.support_email.string'),
            'support_email.required' => __('validation.custom.configuration.support_email.required'),
            'support_telephone.string' => __('validation.custom.configuration.support_telephone.string'),
            'support_telephone.required' => __('validation.custom.configuration.support_telephone.required'),
        ];
    }
}
