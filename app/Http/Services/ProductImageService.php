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
    protected const imageDirectory = "public/files/products/images";
    protected const addToDatabase = true;

    public function imageUpload($images, $product_id, $order = null){
        //$imageName = $image ?? $image->uniqid().Str::random(4).'.'.$image->getClientOriginalExtension();
        $uploadFiles = [];
        foreach ($images as $image){
            $imageName = $image->hashName();
            $image->store(self::imageDirectory);
            $path_directory = self::imageDirectory . '/' . $imageName;
            //$url = asset('storage/' . str_replace('public/', '', $path_directory));
            $path = parse_url(asset('storage/' . str_replace('public/', '', $path_directory)), PHP_URL_PATH);
            if (self::addToDatabase) {
                $uploadFiles[] = $this->storeFile($imageName ,$product_id,$order,$path);
            }
        }
            if ($uploadFiles) return $uploadFiles;

        return false;
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

    public function deleteFile($imageId)
    {
        $deleteItem = ProductImage::find($imageId);
        if ($deleteItem){
            $fileFullPath = self::imageDirectory . '/' . $deleteItem->name;
            $deleteItem->delete();
            Storage::delete($fileFullPath);
            return true;

        }else return false;
    }
}








?>
