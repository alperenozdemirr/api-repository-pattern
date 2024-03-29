<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Category;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRepository extends BaseRepository
{

    public function __construct(Category $model = null)
    {
        if($model === null) {
            $model = new Category();
        }
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return void
     */
    protected function validateExistence(array $data){
        if (!empty($data['parent_id']) && !is_null($data['parent_id'])) {
            $item = Category::find($data['parent_id']);
            if (empty($item)) {
                throw new HttpResponseException(
                    response()->json(['parent_id' => [
                        "This " . $data['parent_id'] . " id is not found"
                    ]], 422)
                );
            }
        }
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $this->validateExistence($data);

        return parent::create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        $this->validateExistence($data);

        return parent::update($id,$data);
    }

}
?>
