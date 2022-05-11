<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'status' => true,
            'result' => $posts,
            'message' => 'Successfully retrieved posts.',
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts',
            'content' => 'required|string',
        ]);
        $post = Post::create($request->all());

        return response()->json([
            'status' => true,
            'result' => $post,
            'message' => 'Successfully created post.',
        ], 200);
    }

    public function update(Post $post, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'content' => 'required|string',
        ]);
        $post->update($request->all());
        return response()->json([
            'status' => true,
            'result' => $post,
            'message' => 'Successfully updated post.',
        ], 200);
    }

    public function show(Post $post)
    {
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found.',
            ], 404);
        } else {
            return response()->json([
                'status' => true,
                'result' => $post,
                'message' => 'Successfully retrieved post.',
            ], 200);
        }
    }

    public function delete(Post $post)
    {
        $post->delete();
        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted post.',
        ], 200);
    }
}
