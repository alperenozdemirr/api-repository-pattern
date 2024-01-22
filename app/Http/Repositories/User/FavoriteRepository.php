<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class FavoriteRepository extends BaseRepository
{

    public function __construct(Favorite $model = null)
    {
        if($model === null) {
            $model = new Favorite();
        }
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return void
     */
    protected function validateExistence(array $data){
        $product = Product::find($data['product_id']);
        $favoriteCheck = $this->model->where('product_id',$data['product_id'])->exists();
        $stock = $product->stock;
        if ($favoriteCheck) {
            throw new HttpResponseException(
                response()->json(['exists_item' => [
                    "This product is available in your favourites"
                ]], 422)
            );
        }
        if (empty($product) && $stock != 0) {
            throw new HttpResponseException(
                response()->json(['product' => [
                    "This product with code ". $data['product_id'] ." was not found"
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
        $data['user_id'] = Auth::user()->id;
        return parent::create($data);
    }


}

?>
