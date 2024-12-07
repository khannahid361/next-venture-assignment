<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostFormRequest;
use App\Repositories\Post\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogPostController extends Controller
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        return $this->postRepository->getAllPosts();
    }

    public function store(BlogPostFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $blogPost = $this->postRepository->createPost($request->all());
            DB::commit();
            $output = [
                'status' => 'success',
                'message' => 'Post created successfully',
                'data' => $blogPost
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

    public function show($id)
    {
        $data = $this->postRepository->getPostById($id);

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }
        return response()->json($data);
    }

    public function update(BlogPostFormRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $blogPost = $this->postRepository->updatePost($id, $request->all());
            DB::commit();
            $output = [
                'status' => 'success',
                'message' => 'Post Updated successfully',
                'data' => $blogPost
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $blogPost = $this->postRepository->deletePost($id);
            DB::commit();
            $output = [
                'status' => 'success',
                'message' => 'Post Deleted successfully',
                'data' => $blogPost
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

    public function userPosts()
    {
        $data = $this->postRepository->userPosts();
        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }
        return response()->json($data); 
    }
}
