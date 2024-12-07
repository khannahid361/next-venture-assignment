<?php

namespace App\Repositories\Post;

interface PostRepositoryInterface
{
    public function getAllPosts();
    public function userPosts();
    public function getPostById($id);
    public function createPost(array $data);
    public function updatePost($id, array $data);
    public function deletePost($id);
}