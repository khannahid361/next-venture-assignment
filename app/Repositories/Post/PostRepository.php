<?php

namespace App\Repositories\Post;

use App\Models\BlogPost;

class PostRepository implements PostRepositoryInterface
{
    public function getAllPosts()
    {
        return BlogPost::with('user')->get();
    }

    public function userPosts()
    {
        return BlogPost::with('user')->where('user_id', auth()->user()->id)->get();
    }

    public function getPostById($id)
    {
        return BlogPost::with('user')->find($id);
    }

    public function createPost(array $data)
    {
        return BlogPost::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'user_id' => auth()->user()->id,
        ]);
    }

    public function updatePost($id, array $data)
    {
        $post = BlogPost::find($id);
        if(!$post)
        {
            return 'Post not found';
        }
        $post->update([
            'title' => $data['title'],
            'body' => $data['body'],
            'user_id' => auth()->user()->id,
        ]);
        return $post;
    }

    public function deletePost($id)
    {
        $blog = BlogPost::find($id);
        if ($blog) {
            $blog->delete();
            return "Post deleted successfully";
        }
        return 'Post not found';
    }
}
