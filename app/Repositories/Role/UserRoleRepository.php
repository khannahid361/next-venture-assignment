<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Models\UserRole;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRolePermissionById($id)
    {
        return Role::with('permissions')->find($id);
    }

    public function addUserToRole(array $data) {
        $check = UserRole::firstWhere(['user_id' =>$data['user_id'],'role_id' => $data['role_id']]);
        if(!$check) {
            return UserRole::create([
                'user_id' => $data['user_id'],
                'role_id' => $data['role_id']
            ]);
        }
        else {
            return 'User already has this role';
        }
    }

    public function currentRoles($userId)
    {
        $roles = UserRole::where('user_id', $userId)->with('role')->get();

        $roleNames = $roles->pluck('role.name');

        return $roleNames;
    }
}
