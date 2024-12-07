<?php
namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;

class UserPermissionRepository implements UserPermissionRepositoryInterface
{
    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function getPermissionByUserId($id)
    {
        $permissions = UserPermission::with('permission')->where('user_id',$id)->get();
        $permissionNames = $permissions->pluck('permission.name');

        return $permissionNames;
    }

    public function assignUserPermission(array $data)
    {
        $check = UserPermission::firstWhere(['user_id' =>$data['user_id'],'permission_id' => $data['permission_id']]);
        if(!$check) {
            return UserPermission::create([
                'user_id' => $data['user_id'],
                'permission_id' => $data['permission_id']
            ]);
        }
        else {
            return 'User already has this permission';
        }
    }
}