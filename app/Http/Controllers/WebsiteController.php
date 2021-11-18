<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WebsiteController extends Controller
{
    public function index() {
        return response()->json(['code' => 200, 'data' => Website::all()]);
    }

    public function store(Request $request) {
        $rules = [
            'name' => ['required','string','min:2','max:255','unique:websites'],
            'description' => ['required','string'],
            'domain' => ['required','string','url'],
            'owners_name' => ['required','string','min:2','max:255'],
            'owners_email' => ['nullable','string','email'],
            'owners_phone' => ['nullable','min:5','max:13'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' =>  $validator->messages()
            ]);
        }

        $website = Website::create($request->all());
        if ($website) {
            return response()->json([
                'code' => 200,
                'message' => 'Website Created Successfully'
            ]);
        }

        return response()->json([
            'code' => 100,
            'message' =>  'Failed to create website. Please try again.'
        ]);
    }

    public function update($id, Request $request) {
        $rules = [
            'name' => ['required','string','min:2','max:255','unique:websites,name,'.$id],
            'description' => ['required','string'],
            'domain' => ['required','string','url'],
            'owners_name' => ['required','string','min:2','max:255'],
            'owners_email' => ['nullable','string','email'],
            'owners_phone' => ['nullable','min:5','max:13'],
        ];

        $this->validate($request, $rules);

        $website = Website::where('id', $id)
        ->update($request->all());
        if ($website) {
            return response()->json([
                'code' => 200,
                'message' => 'Website Updated Successfully'
            ]);
        }

        return response()->json([
            'code' => 100,
            'message' =>  'Failed to update website. Please try again.'
        ]);
    }
}
