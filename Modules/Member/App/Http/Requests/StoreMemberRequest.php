<?php

namespace Modules\Member\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Rules\StrongPasswordRule;

class StoreMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'account_id' => 'required|unique:users,account_id',
            'name' => 'bail|required|string',
            'email' => 'bail|required|email|unique:users,email',
            'address' => 'bail|nullable|string',
            'password' => ['bail', 'required', 'min:6', 'required_with:password_confirm', new StrongPasswordRule()],
            'password_confirm' => 'bail|required|same:password',
            'avatar' => 'bail|nullable|file|mimes:jpeg,jpg,png,gif|max:2000'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
