<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignUserRoleFormRequest;
use App\Models\User;
use App\Repositories\Role\UserRoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller
{
    private $userRoleRepository;
    public function __construct(UserRoleRepositoryInterface $userRoleRepository)
    {
        $this->userRoleRepository = $userRoleRepository;
    }

    public function index()
    {
        return $this->userRoleRepository->getAllRoles();
    }

    public function getRoleWisePermission($id)
    {
        return $this->userRoleRepository->getRolePermissionById($id);
    }

    public function assignUserRole(AssignUserRoleFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = $this->userRoleRepository->addUserToRole($request->all());
            DB::commit();
            $output = [
                'status' => 'success',
                'data' => $result
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($output);
    }

    public function userRoles($id)
    {
        $data = $this->userRoleRepository->currentRoles($id);
        if (!$data) {
            return response()->json(['error' => 'User Does not exist / No roles found'], 404);
        }
        return response()->json($data);
    }
}
