<?php

namespace App\Traits;

/**
 * for hattp resposes succsess or error messages
 */
trait HttpResponses
{
    protected function succsess($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Request was successful',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = null, $code)
    {
        return response()->json([
            'status' => 'Error has occurred',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
