<?php

namespace App\Repositories\Role;

interface UserRoleRepositoryInterface
{
    public function getAllRoles();
    public function getRolePermissionById($id);
    public function addUserToRole(array $data);
    public function currentRoles($userId);
}
