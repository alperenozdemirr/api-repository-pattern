<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Http\Services\GeneralSettingService;
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
    protected $generalSettingService = null;
    public function __construct(Order $model = null, ShoppingCartService $shoppingCartService, GeneralSettingService $generalSettingService)
    {
        if($model === null) {
            $model = new Order();
        }
        $this->shoppingCartService = $shoppingCartService;
        $this->generalSettingService = $generalSettingService;
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return void
     */
    protected function validateExistence(array $data){
        if (empty($this->generalSettingService->getShippedCost())){
            throw new HttpResponseException(
                response()->json(['shipped_cost' => [
                    "Systemic missing data: Undetermined shipping cost."
                ]], 422)
            );
        }
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

    /**
     * @param $data
     * @return mixed
     */
    public function create($data){
        $this->validateExistence($data);
        $totalPrice = $this->shoppingCartService->getTotalPrice();
        $data['user_id'] = Auth::user()->id;
        $data['product_amount'] = $this->shoppingCartService->getTotalProductAmount();
        $data['total_price'] = $totalPrice + $this->generalSettingService->getShippedCost();
        $data['shipping_cost'] = $this->generalSettingService->getShippedCost();

        if (!isset($data['invoice_address_id']))  $data['invoice_address_id'] = $data['address_id'];

        return parent::create($data);
    }


}






?>
