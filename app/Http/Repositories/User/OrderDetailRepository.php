<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Jobs\OrderInvoiceMailJob;
use App\Mail\OrderInvoiceMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use App\Enums\ShipmentStatus;

class OrderDetailRepository extends BaseRepository
{
    public function __construct(OrderDetail $model = null)
    {
        if($model === null) {
            $model = new OrderDetail();
        }
        parent::__construct($model);
    }

    /**
     * @param $id
     * @return void
     */
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

    /**
     * @param $productId
     * @param $amount
     * @return void
     */
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

    /**
     * @param $orderId
     * @return bool
     */
    public function create($orderId)
    {
        $this->validateExistenceId($orderId);
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
        if (!empty($orderDetails)){
            $save = $this->model->insert($orderDetails);
            if ($save) {
                $order = Order::find($orderId);
                ShoppingCart::where('user_id',Auth::user()->id)->delete();
                $email = Auth::user()->email;
                $products = OrderDetail::where('order_id',$orderId)->with('products')->get();
                $data['order_number'] = $orderId;
                $data['time'] = $order->created_at;
                $data['shipping_cost'] = $order->shipping_cost;
                $data['total_price'] = $order->total_price;
                $data['order_status'] = ShipmentStatus::ORDER_RECEIVED;
                $address = $order->address;
                $invoice= $order->invoice_address;
                    foreach ($orderDetails as $item){
                        $product = Product::find($item['product_id']);
                        $product->decrement('stock',$item['product_amount']);
                    }
                dispatch(new OrderInvoiceMailJob($email, $products, $data, $address, $invoice));
                return true; } else return false;
        } else return false;
    }


}






?>
