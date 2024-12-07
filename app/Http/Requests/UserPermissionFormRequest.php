<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPermissionFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric|exists:users,id', 
            'permission_id' => 'required|numeric|exists:permissions,id', 
        ];
    }
}
