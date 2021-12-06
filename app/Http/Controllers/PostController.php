<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponder;

    public function publishPost(Request $request)
    {
        $validated = $this->validateRequest([
            'website_id' => ['required', 'integer', 'exists:websites,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required|string|max:3000'],
        ]);
        Post::create($validated);
        return $this->success();
    }
}
