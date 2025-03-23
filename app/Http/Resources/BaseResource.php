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
            'message' => '成功',
        ];
    }

    public static function collection($resource)
    {
        $collection = parent::collection($resource);
        $collection->additional([
            'status' => 200,
            'message' => '成功',
        ]);
        return $collection;
    }

    public static function error($message = '錯誤', $status = 400): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null,
        ], $status);
    }
} 