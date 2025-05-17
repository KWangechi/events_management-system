<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    /**
     * The action for the request.
     *
     * @var string
     */
    protected string $action = '';


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

        $optionalField = $this->action === 'login' ? 'required|' : 'sometimes|';

        return [
            'name' => $optionalField . 'string|max:255',
            'email' => 'required|string|email|max:255|' ,
            'password' => 'required|string|min:8',
            'confirmed_password' => $optionalField . 'string|min:8|same:password',
            'organization_id' => $optionalField . 'exists:organizations,id',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'confirmed_password.required' => 'The confirmed password field is required.',
            'organization_id.required' => 'The organization ID field is required.',
            'organization_id.exists' => 'The selected organization ID is invalid.',
        ];
    }
    /**
     * Set the action for the request.
     *
     * @param string $action
     * @return void
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }
    /**
     * Get the action for the request.
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
