<?php

namespace App\Http\Controllers\API\Admin\Product;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductImageRequest;
use App\Http\Resources\Public\ProductImageResource;
use App\Http\Services\ProductImageService;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    protected $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

    /**
     * @param ProductImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductImageRequest $request){
        $images = $request->file('name');
        $order = $request['image_order'];
        $order = empty($order) ? null : $order;
        $save = $this->productImageService->imageUpload($images,$request['product_id'],$order);
        if($save){
            return response()->json(['message' => 'The item has been successfully created.','item' => ProductImageResource::collection($save)],201);
        }
        return ResponseHelper::failedCreate();
    }

    /**
     * @param $imageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($imageId){
        $delete = $this->productImageService->deleteFile($imageId);
        if($delete){
            return ResponseHelper::successDeleted();
        }
        return ResponseHelper::failedDelete();

    }

}
