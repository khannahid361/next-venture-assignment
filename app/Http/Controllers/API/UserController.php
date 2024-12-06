<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->getUserById($id);
        return response()->json($user);
    }

    public function store(UserFormRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = $this->userRepository->createUser($request->all());
            DB::commit();
            $output = [
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => $user
            ];
        }
        catch(\Exception $e){
            DB::rollBack();
            $output = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($output);
    }
}
