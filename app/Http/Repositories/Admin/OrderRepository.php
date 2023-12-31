<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Jobs\OrderCargoMailJob;
use App\Models\Order;
use App\Enums\ShipmentStatus;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $model = null)
    {
        if($model === null) {
            $model = new Order();
        }
        parent::__construct($model);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        $order = $this->model->find($id);

        if (empty($order)) {
            throw new HttpResponseException(
                response()->json(['item' => [
                    "This item with code ". $id ." was not found"
                ]], 422)
            );
        }
        $email = $order->user->email;

        if ($data['shipment_status'] == strtolower(ShipmentStatus::SHIPPED)){
            $mailData['name'] = $order->user->name;
            $mailData['time'] =  $order->created_at;
            $mailData['code'] =  $order->id;
            $mailData['total_price'] =  $order->total_price;
            $mailData['shipment_status'] = ShipmentStatus::SHIPPED;
            dispatch(new OrderCargoMailJob($email,$mailData));
        }



        return parent::update($id, $data);
    }
}







?>
