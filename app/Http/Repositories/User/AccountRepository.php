<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Http\Resources\Public\FileResource;
use App\Http\Services\FileService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountRepository extends BaseRepository
{
    protected $fileService = null;
    public function __construct(User $model = null, FileService $fileService)
    {
        if($model === null) {
            $model = new User();
        }
        $this->fileService = $fileService;
        parent::__construct($model);
    }

    public function imageChange($data)
    {
        $user = $this->model->find(Auth::user()->id);

        if ($user->image){
            $this->fileService->imageDelete($user->image->id);
            $file = $this->fileService->imageUpload($data['file']);
            return new FileResource($file);
        }
        $file = $this->fileService->imageUpload($data['file']);
        return new FileResource($file);
    }
}








?>
