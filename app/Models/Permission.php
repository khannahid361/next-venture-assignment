<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'user_id','id');
    }
}
