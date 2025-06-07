<?php

namespace Modules\Member\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Rules\StrongPasswordRule;

class UpdateMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'account_id' => 'required|unique:users,account_id,' . $this->member,
            'name' => 'bail|required|string',
            'email' => 'bail|required|email|unique:users,email,' . $this->member,
            'password' => ['bail', 'nullable', 'min:6', 'required_with:password_confirm', new StrongPasswordRule()],
            'password_confirm' => 'bail|nullable|same:password',
            'status' => 'required|integer|in:1,0',
            'avatar' => 'bail|nullable|file|mimes:jpeg,jpg,png,gif|max:2000',
            'contact_number' => 'bail|nullable|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
