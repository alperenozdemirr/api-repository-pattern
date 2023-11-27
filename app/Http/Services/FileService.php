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
    protected const fileDirectory = "users/files";
    protected const userImageDirectory = "users/images";
    protected const addToDatabase = true;

    public function fileUpload($file,$content_type = null)
    {
        $file_type = FileType::FILE;
        if($content_type==null){
            $content_type = ContentType::USER;
        }
        $fileName = $file ?? $file->uniqid().Str::random(4).'.'.$file->getClientOriginalExtension();
        Storage::disk('local')->put(self::fileDirectory . '/' . $fileName, file_get_contents($file));
        $path = self::fileDirectory . '/' . $fileName;

        if (self::addToDatabase) {
            return $this->storeFile($fileName ,$file_type,$content_type,$path);
        }

        return null;
    }

    public function imageUpload($file,$content_type = null){
        $file_type = FileType::IMAGE;
        if($content_type==null){
            $content_type = ContentType::USER;
        }
        $fileName = $file ?? $file->uniqid().Str::random(4).'.'.$file->getClientOriginalExtension();
        Storage::disk('local')->put(self::userImageDirectory . '/' . $fileName, file_get_contents($file));
        $path = self::userImageDirectory . '/' . $fileName;
        if (self::addToDatabase) {
            return $this->storeFile($fileName ,$file_type,$content_type,$path);
        }

        return null;
    }

    protected function storeFile($fileName,$file_type,$content_type,$path)
    {

        $fileRecord = File::create([
            'file_name' => $fileName,
            'path' => $path,
            'user_id' => Auth::user()->id,
            'file_type' => $file_type,
            'content_type' =>$content_type
        ]);

        return $fileRecord;
    }
    protected function deleteFile($fileId)
    {
        $file =  File::find($fileId);
        if ($file){
            $file->delete();
            return true;
        }else return false;
    }
}

?>
