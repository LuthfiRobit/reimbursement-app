<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PermissionService
{
    public function errorResponse(string $message, int $statusCode = 400)
    {
        return response()->json(['success' => false, 'message' => $message], $statusCode);
    }

    public function errorView(string $message)
    {
        return redirect()->back()->withInput()->with('error', $message);
    }

    public function successResponse(string $message, $data = null, int $statusCode = 200)
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $statusCode);
    }

    public function successView(string $message)
    {
        return redirect()->back()->withInput()->with('success', $message);
    }

    public function validateData(array $data, array $rules, array $messages = [])
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();

            $response = [
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => []
            ];

            foreach ($errors->keys() as $key) {
                $response['errors'][$key] = $errors->get($key);
            }

            return response()->json($response, 400);
        }

        return null;
    }

    public function validateDataView(array $data, array $rules, array $messages = [])
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return null;
    }
}
