<?php

namespace App\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

trait ApiResponder
{
    protected function success($data = null, $code = 200)
    {
        $response = [
            'statusCode' => $code,
            'message' => 'Success',
        ];
        if ($data) $response['data'] = $data;
        return response()->json($response, $code);
    }

    protected function error($message, $code, $errors = null)
    {
        $response = [
            'statusCode' => $code,
            'message' => $message,
        ];
        if ($errors) $response['errors'] = $errors;
        return response()->json($response, $code);
    }

    protected function validateRequest($rules, $messages = [])
    {
        $validator = Validator::make(Request::all(), $rules, $messages);
        if ($validator->fails()) $this->error('Request have invalid argument(s).', 400, collect($validator->errors())->map(function ($errors) {
            return $errors[0];
        }))->throwResponse();
        return $validator->validated();
    }
}
