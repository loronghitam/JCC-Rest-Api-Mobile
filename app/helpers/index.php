<?php

use Illuminate\Support\Facades\Response;

function apiResponse($code, $status, $massage, $data = null)
{
    $data = [
        'meta' => [
            'code' => $code,
            'status' => $status,
            'message' => $massage
        ],
        'data' => $data
    ];
    return Response::json($data, $code);
}
