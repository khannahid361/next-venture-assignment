<?php
namespace App\Repositories\Permission;

interface UserPermissionRepositoryInterface
{
    public function getAllPermissions();
    public function getPermissionByUserId($id);
    public function assignUserPermission(array $data);
}