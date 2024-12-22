<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // create post

    public function createNewPost() {
        return view('create-new-post');
    }

    public function storePost(Request $request) {
        $validated = $request->validate([
            'name' => 'required | max: 255 ',
            'description' => 'required | max: 1024 ',
            'image' => 'nullable | mimes:jpg,png,jpeg'
        ]);

        // Upload image
        $imageName = null;
        if(isset($request->image)) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        // Add new post
        $post = new Post;
        $post->name = $request->name;
        $post->description = $request->description;
        $post->image =  $imageName;
        $post->save();
        return redirect()->route('home')->with('success', 'Your post has been created!');
    }

    public function editPost($id) {
        $post = Post::findOrFail($id);
        return view('edit-post', ['post' => $post]);
    }

    public function updatePost($id, Request $request) {
        $validated = $request->validate([
            'name' => 'required | max: 255 ',
            'description' => 'required | max: 1024 ',
            'image' => 'nullable | mimes:jpg,png,jpeg'
        ]);

        // Update post
        $post = Post::findOrFail($id);
        $post->name = $request->name;
        $post->description = $request->description;
        // Upload image
        if(isset($request->image)) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image =  $imageName;
        }
        $post->save();
        return redirect()->route('home')->with('success', 'Your post has been updated!');
    }

    public function deletePost($id) {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('home')->with('success', 'Your post has been deleted!');
    }
}
