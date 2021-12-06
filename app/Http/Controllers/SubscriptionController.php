<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    use ApiResponder;

    public function subscribe(Request $request)
    {
        $validated = $this->validateRequest([
            'website_id' => ['required', 'integer', 'exists:websites,id'],
            'email' => ['required', 'email', 'max:255', Rule::unique('subscriptions', 'email')->where('website_id', $request->input('website_id'))],
        ]);

        Subscription::create($validated);

        return $this->success();
    }
}
