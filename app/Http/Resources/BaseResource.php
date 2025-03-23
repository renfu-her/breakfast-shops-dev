<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public static $wrap = 'data';

    public function with($request)
    {
        return [
            'status' => 200,
            'message' => 'Success',
        ];
    }

    public static function collection($resource)
    {
        $collection = parent::collection($resource);
        $collection->additional([
            'status' => 200,
            'message' => 'Success',
        ]);
        return $collection;
    }

    public static function empty($message = 'No data found'): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
            'data' => [],
        ], 200);
    }

    public static function error($message = 'Error', $status = 500): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null,
        ], $status);
    }
} 