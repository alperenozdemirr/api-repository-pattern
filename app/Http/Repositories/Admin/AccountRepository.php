<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Http\Resources\Public\FileResource;
use App\Http\Services\FileService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountRepository extends BaseRepository
{
    protected $fileService = null;

    /**
     * @param User|null $model
     * @param FileService $fileService
     */
    public function __construct(User $model = null, FileService $fileService)
    {
        if($model === null) {
            $model = new User();
        }
        $this->fileService = $fileService;
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function updateV2(array $data)
    {
        $id = Auth::user()->id;
        return parent::update($id, $data);
    }

    /**
     * @param array $data
     * @return FileResource
     */
    public function imageChange(array $data)
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
