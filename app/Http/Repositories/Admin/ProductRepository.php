<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Http\Services\ProductImageService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRepository extends BaseRepository
{
    protected $productImageService;

    /**
     * @param Product|null $model
     * @param ProductImageService $productImageService
     */
    public function __construct(Product $model = null, ProductImageService $productImageService)
    {
        if($model === null) {
            $model = new Product();
        }
        parent::__construct($model);
        $this->productImageService = $productImageService;
    }

    /**
     * @param array $data
     * @return void
     */
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

    /**
     * @param $id
     * @param array $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        $this->validateExistence($data);

        return parent::update($id, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $product = $this->model->find($id);
        $productImages = $product->images;
        foreach ($productImages as $productImage){
            $this->productImageService->deleteFile($productImage->id);
        }

        return parent::delete($id);
    }

}
?>
