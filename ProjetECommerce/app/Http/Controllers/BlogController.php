<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = BlogResource::collection(Blog::all());

        return response()->json([
            'blogs' => $blogs
        ]);
    }

    public function show($id)
    {
        $blog = BlogResource::make(Blog::find($id));

        return response()->json([
            'blog' => $blog
        ]);
    }

    public function store(BlogRequest $request)
    {

        $userId = $request->input('user_id');
        $user = User::where('id' , $userId)->first();

        $blog = new Blog;
        $blog->content = $request->input('content');
        $blog->date = $request->input('date');
        $blog->user()->associate($user);
        $blog->save();

        return response()->json([
            'blog' => $blog
        ]);
    }

    public function update($id, BlogRequest $request){

        $blog = Blog::find($id);
        $userId = $request->input('user_id');
        $user = User::where('id' , $userId)->first();
        $blog->content = $request->input('content');
        $blog->date = $request->input('date');
        $blog->user()->associate($user);
        $blog->save();

        return response()->json([
            'blog'=> $blog
        ]);

    }

    public function destroy($id){

        $blog = Blog::find($id);
        $blog->delete();
        $blogs = BlogResource::collection(Blog::all());

        return response()->json([
            'blogs' => $blogs
        ]);
    }

}
