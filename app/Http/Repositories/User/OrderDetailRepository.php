<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class OrderDetailRepository extends BaseRepository
{
    public function __construct(OrderDetail $model = null)
    {
        if($model === null) {
            $model = new OrderDetail();
        }
        parent::__construct($model);
    }

    protected function validateExistenceId($id){
        $order = Order::find($id);
        if (empty($order)) {
            throw new HttpResponseException(
                response()->json(['order' => [
                    "This item with code ". $id ." was not found"
                ]], 422)
            );
        }
    }
    protected function checkStock($productId,$amount){
        $product = Product::find($productId);

        if (!$product){
            throw new HttpResponseException(
                response()->json(['error' => [
                    "Product not found"
                ]], 404)
            );
        }
        if($product->stock < $amount){
            throw new HttpResponseException(
                response()->json(['amount' => [
                    "insufficient stock"
                ]], 422)
            );
        }
    }
    public function create($orderId)
    {
        $this->validateExistenceId($orderId);
        $data = null;
        $baskets = ShoppingCart::where('user_id',Auth::user()->id)->get();
        foreach ($baskets as $basket){
            $this->checkStock($basket->product_id,$basket->amount);
            $orderDetails[] = [
                'order_id' =>$orderId,
                'product_id' => $basket->product_id,
                'product_price' => $basket->product->discount_price,
                'product_amount' => $basket->amount
            ];
        }
        //dd($orderDetails);
        if (!empty($orderDetails)){
            $save = $this->model->insert($orderDetails);
            if ($save) { return true; } else return false;
        } else return false;
        //return parent::create($data);
    }


}






?>
