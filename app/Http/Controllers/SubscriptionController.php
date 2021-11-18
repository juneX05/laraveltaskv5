<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index() {
        $data = Subscription::with(['user','website'])
            ->get();
        return response()->json(['code' => 200, 'data' => $data]);
    }

    public function subscribe(Request $request) {
        $rules = [
            'user_id' => ['required','integer', 'exists:App\Models\User,id'],
            'website_id' => ['required', 'integer', 'exists:App\Models\Website,id'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' =>  $validator->messages()
            ]);
        }

        $data = $request->all();

        $post = Subscription::create($data);
        if ($post) {
            return response()->json([
                'code' => 200,
                'message' => 'User Subscribed Successfully'
            ]);
        }

        return response()->json([
            'code' => 100,
            'message' =>  'Failed to subscribe user. Please try again.'
        ]);
    }

    public function unsubscribe(Request $request) {
        $id = $request->id;
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json([
                'code' => 100,
                'message' =>  'Cannot find subscription.'
            ]);
        }

        $post = Subscription::where('id', $id)->update(['subscription_status_id' => 4]);
        if ($post) {
            return response()->json([
                'code' => 200,
                'message' => 'User UnSubscribed Successfully'
            ]);
        }

        return response()->json([
            'code' => 100,
            'message' =>  'Failed to unsubscribe user. Please try again.'
        ]);
    }
}
