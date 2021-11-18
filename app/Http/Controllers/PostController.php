<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index() {
        return response()->json(['code' => 200, 'data' => Post::all()]);
    }

    public function store(Request $request) {
        $rules = [
            'title' => ['required','string','min:2','max:255','unique:posts'],
            'body' => ['required'],
            'website_id' => ['required','integer']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' =>  $validator->messages()
            ]);
        }

        $post = Post::create($request->all());
        if ($post) {
            return response()->json([
                'code' => 200,
                'message' => 'Post Created Successfully'
            ]);
        }

        return response()->json([
            'code' => 100,
            'message' =>  'Failed to create post. Please try again.'
        ]);
    }

    public function update($id, Request $request) {
        $rules = [
            'title' => ['required','string','min:2','max:255','unique:posts,title,'.$id],
            'body' => ['required'],
            'website_id' => ['required','integer'],
        ];

        $this->validate($request, $rules);

        $website = Post::where('id', $id)
        ->update($request->all());
        if ($website) {
            return response()->json([
                'code' => 200,
                'message' => 'Post Updated Successfully'
            ]);
        }

        return response()->json([
            'code' => 100,
            'message' =>  'Failed to update post. Please try again.'
        ]);
    }
}
