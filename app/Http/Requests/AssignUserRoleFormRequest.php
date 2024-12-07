<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignUserRoleFormRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric|exists:users,id', 
            'role_id' => 'required|numeric|exists:roles,id', 
        ];
    }
}
