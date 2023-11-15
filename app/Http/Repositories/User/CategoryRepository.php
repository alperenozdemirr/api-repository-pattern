<?php
namespace App\Http\Repositories\User;

use App\Models\Category;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CategoryRepository extends BaseRepository
{

    public function __construct(Category $model = null)
    {
        if($model === null) {
            $model = new Category();
        }
        parent::__construct($model);
    }

    public function create(array $data)
    {
        if (!is_null($data['parent_id'])){
            $item = (new Category())->find($data['parent_id']);
            if(!$item){
                return response()->json(
                    [
                        'errors' => [
                            'parent_id' => ["This {$data['parent_id']} id is not found"]
                        ]
                    ],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }
        return parent::create($data);
    }

}
?>
