<?php
namespace App\Http\Services;

use App\Enums\ContentType;
use App\Enums\FileType;
use App\Models\File;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImageService
{
    protected const imageDirectory = "files/products/images";
    protected const addToDatabase = true;

    public function imageUpload($image, $product_id, $order = null){
        $imageName = $image ?? $image->uniqid().Str::random(4).'.'.$image->getClientOriginalExtension();
        Storage::disk('local')->put(self::imageDirectory . '/' . $imageName, file_get_contents($image));
        $path = self::imageDirectory . '/' . $imageName;
        if (self::addToDatabase) {
            return $this->storeFile($imageName ,$product_id,$order,$path);
        }

        return null;
    }

    protected function storeFile($imageName ,$product_id,$order,$path)
    {

        $imageRecord = ProductImage::create([
            'name' => $imageName,
            'image_path' => $path,
            'product_id' => $product_id,
            'image_order' => $order,
        ]);

        return $imageRecord;
    }

    protected function deleteFile($imageId)
    {
        $image =  ProductImage::find($imageId);
        if ($image){
            $image->delete();
            return true;
        }else return false;
    }
}








?>
