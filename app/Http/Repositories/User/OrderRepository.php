<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Http\Services\ShoppingCartService;
use App\Models\Address;
use App\Models\Order;
use App\Models\ShoppingCart;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository
{
    protected $shipping_cost = 20.00;
    protected $shoppingCartService = null;
    public function __construct(Order $model = null, ShoppingCartService $shoppingCartService)
    {
        if($model === null) {
            $model = new Order();
        }
        $this->shoppingCartService = $shoppingCartService;
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return void
     */
    protected function validateExistence(array $data){
        $basketCount = ShoppingCart::where('user_id',Auth::user()->id)->count();
        if ($basketCount == 0) {
            throw new HttpResponseException(
                response()->json(['basket_amount' => [
                    "This operation requires your cart to be filled."
                ]], 422)
            );
        }
        $address = Address::find($data['address_id']);

        if (empty($address)) {
            throw new HttpResponseException(
                response()->json(['address' => [
                    "This address with code ". $data['address_id'] ." was not found"
                ]], 422)
            );
        }

        if(isset($data['invoice_address_id'])){
            $invoice_address = Address::find($data['invoice_address_id']);
            if (empty($invoice_address)) {
                throw new HttpResponseException(
                    response()->json(['invoice_address' => [
                        "This invoice with code ". $data['invoice_address_id'] ." was not found"
                    ]], 422)
                );
            }
        }

    }

    public function create($data){
        $this->validateExistence($data);
        $totalPrice = $this->shoppingCartService->getTotalPrice();
        $data['user_id'] = Auth::user()->id;
        $data['product_amount'] = $this->shoppingCartService->getTotalProductAmount();
        $data['total_price'] = $totalPrice + $this->shipping_cost;
        $data['shipping_cost'] = $this->shipping_cost;

        if (!isset($data['invoice_address_id']))  $data['invoice_address_id'] = $data['address_id'];

        return parent::create($data);
    }


}






?>
