<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRepository extends BaseRepository
{

    public function __construct(Product $model = null)
    {
        if($model === null) {
            $model = new Product();
        }
        parent::__construct($model);
    }

    protected function validateExistence(array $data){
        $item = Category::find($data['category_id']);
        if (empty($item)) {
            throw new HttpResponseException(
                response()->json(['category' => [
                    "This category with code ". $data['category_id'] ." was not found"
                ]], 422)
            );
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

    public function update($id, array $data)
    {
        $this->validateExistence($data);

        return parent::update($id, $data);
    }

}
?>
