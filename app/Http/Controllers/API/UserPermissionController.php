<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Permission\UserPermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPermissionController extends Controller
{
    private $userPermissionRepository;
    public function __construct(UserPermissionRepositoryInterface $userPermissionRepository)
    {
        $this->userPermissionRepository = $userPermissionRepository;
    }

    public function index()
    {
        return $this->userPermissionRepository->getAllPermissions();
    }

    public function getPermissionByUserId($id)
    {
        return $this->userPermissionRepository->getPermissionByUserId($id);
    }

    public function assignUserPermission(Request $request)
    {
        DB::beginTransaction();
        try {
            $result = $this->userPermissionRepository->assignUserPermission($request->all());
            DB::commit();
            $output = [
                'status' => 'success',
                'message' => 'User permission assigned successfully',
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
}
