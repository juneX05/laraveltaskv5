<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Traits\ApiResponder;

class WebsiteController extends Controller
{
    use ApiResponder;

    public function listWebsites() {
        return $this->success([
            'websites' => Website::select('id', 'domain')->orderBy('id')->get(),
        ]);
    }
}
