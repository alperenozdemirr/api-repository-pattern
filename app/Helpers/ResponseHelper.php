<?php
namespace App\Helpers;

class ResponseHelper
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function forbidden()
    {
        return response()->json([
            'error' => 'Forbidden',
            'message' => 'The item could not be found'
        ],404);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function failedCreate()
    {
        return response()->json([
            'error' => 'Failed to created',
            'message' => 'Failed to created the item'
        ], 422);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function failedUpdate()
    {
        return response()->json([
            'error' => 'Failed to update',
            'message' => 'The item could not be updated'
        ], 422);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function failedDelete()
    {
        return response()->json([
            'error' => 'Failed to delete',
            'message' => 'The item could not be updated'
        ], 400);
    }

    public static function successDeleted()
    {
        return response()->json([
            'success' => 'delete',
            'message' => 'Items have been item deleted'
        ], 204);
    }
}
