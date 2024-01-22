<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Http\Resources\Public\ShoppingCartResource;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\b;

class ShoppingCartRepository extends BaseRepository
{
    public function __construct(ShoppingCart $model = null)
    {
        if($model === null) {
            $model = new ShoppingCart();
        }
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return void
     */
    protected function validateExistence(array $data){
        $item = Product::find($data['product_id']);
        $stock = $item->stock;
        if (empty($item)) {
            throw new HttpResponseException(
                response()->json(['product' => [
                    "This product with code ". $data['product_id'] ." was not found"
                ]], 422)
            );
        }
        if ($data['amount'] > $stock){
            throw new HttpResponseException(
                response()->json(['amount' => [
                    "The requested quantity of the product is not available in stock."
                ]], 422)
            );
        }
    }

    /**
     * @param $id
     * @return void
     */
    protected function basketValidatedExistence($id){
        $basket = $this->model->find($id);
        if (empty($basket)) {
            throw new HttpResponseException(
                response()->json(['basket' => [
                    "This basket with code ". $id ." was not found"
                ]], 422)
            );
        }
    }

    /**
     * @param array $data
     * @return ShoppingCartResource
     */
    public function create(array $data)
    {
        $this->validateExistence($data);
        $basket = $this->model->where('user_id', Auth::user()->id)
            ->where('product_id', $data['product_id'])
            ->first();
        if ($basket) {
            $basket->increment('amount', $data['amount']);
            return new ShoppingCartResource($basket);
        }
        $data['user_id'] = Auth::user()->id;
        $createdBasket = parent::create($data);
        return new ShoppingCartResource($createdBasket);
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
    public function amountIncrement($id){
        $this->basketValidatedExistence($id);
        $basket =  $this->model->find($id);
        $basket->increment('amount');
        return $basket;
    }

    /**
     * @param $id
     * @return true
     */
    public function amountDecrement($id){
        $this->basketValidatedExistence($id);
        $basket =  $this->model->find($id);
        if($basket->amount == 1) {
            $basket->delete();
            return true;
        }
        $basket->decrement('amount');
        return $basket;
    }

}






?>
