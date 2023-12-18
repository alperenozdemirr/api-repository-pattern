<?php
namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\File;
use App\Enums\ContentType;
use App\Enums\FileType;
class FileService
{
    protected const fileDirectory = "public/files/users/files";
    protected const userImageDirectory = "public/files/users/images";
    protected const addToDatabase = true;

    public function fileUpload($file,$content_type = null)
    {
        $file_type = FileType::FILE;
        if($content_type==null){
            $content_type = ContentType::USER;
        }
        $fileName = $file->hashName();
        $file->store(self::fileDirectory);
        $path_directory = self::fileDirectory . '/' . $fileName;
        $path = parse_url(asset('storage/' . str_replace('public/', '', $path_directory)), PHP_URL_PATH);
        if (self::addToDatabase) {
            return $this->storeFile($fileName ,$file_type,$content_type,$path);
        }

        return false;
    }

    public function imageUpload($file,$content_type = null){
        $file_type = FileType::IMAGE;
        if($content_type==null){
            $content_type = ContentType::USER;
        }
        $fileName = $file->hashName();
        $file->store(self::userImageDirectory);
        $path_directory = self::userImageDirectory . '/' . $fileName;
        $path = parse_url(asset('storage/' . str_replace('public/', '', $path_directory)), PHP_URL_PATH);
        if (self::addToDatabase) {
            return $this->storeFile($fileName ,$file_type,$content_type,$path);
        }

        return false;
    }

    protected function storeFile($fileName,$file_type,$content_type,$path)
    {

        $fileRecord = File::create([
            'file_name' => $fileName,
            'file_path' => $path,
            'user_id' => Auth::user()->id,
            'file_type' => $file_type,
            'content_type' =>$content_type
        ]);

        return $fileRecord;
    }
    public function fileDelete($fileId)
    {
        $deleteItem =  File::find($fileId);
        if ($deleteItem){
            $fileFullPath = self::fileDirectory . '/' . $deleteItem->file_name;
            $deleted = $deleteItem->delete();
            Storage::delete($fileFullPath);
            if($deleted){ return true;} else return false;

        }else return true;
    }

    public function imageDelete($imageId)
    {
        $deleteItem =  File::find($imageId);
        if ($deleteItem){
            $fileFullPath = self::userImageDirectory . '/' . $deleteItem->file_name;
            $deleteItem->delete();
            Storage::delete($fileFullPath);
            return true;

        }else return false;
    }
}

?>
