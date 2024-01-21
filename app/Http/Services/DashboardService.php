<?php

namespace App\Http\Services;

use App\Enums\ShipmentStatus;
use App\Enums\Status;
use App\Enums\UserType;
use App\Http\Repositories\Admin\DashboardRepository;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\User;


class DashboardService
{
    /**
     * @var float
     */
    protected $total_price = 0.00;

    /**
     * @return array
     */
    public function getUserStats(){
        $user = User::all();

        $totalCount = $user->count();
        $activeCount = $user->where('status',Status::ACTIVE)->count();
        $passiveCount = $user->where('status',Status::PASSIVE)->count();
        $adminCount = $user->where('type',UserType::ADMIN)->count();
        return [
          'totalCount' => $totalCount,
          'activeCount' => $activeCount,
          'passiveCount' => $passiveCount,
          'adminCount' => $adminCount,
        ];
    }

    /**
     * @return array
     */
    public function getProductStats(){
        $totalCount = Product::count();
        return ['totalCount' => $totalCount];
    }

    /**
     * @return array
     */
    public function getBasketStats(){
        $totalCount = ShoppingCart::count();
        return ['totalCount' => $totalCount];
    }

    /**
     * @return array
     */
    public function getFavoriteStats(){
        $totalCount = Favorite::count();
        return ['totalCount' => $totalCount];;
    }

    /**
     * @return array
     */
    public function getOrderStats(){
        $order = Order::all();

        $totalCount = $order->count();
        $newOrderCount = $order->where('shipment_status',strtolower(ShipmentStatus::ORDER_RECEIVED))->count();
        $beingProcessedCount = $order->where('shipment_status',strtolower(ShipmentStatus::BEING_PROCESSED))->count();
        $shippedCount = $order->where('shipment_status',strtolower(ShipmentStatus::SHIPPED))->count();
        $deliveredCount = $order->where('shipment_status',strtolower(ShipmentStatus::DELIVERED))->count();
        $cancelledCount = $order->where('shipment_status',strtolower(ShipmentStatus::CANCELLED))->count();

        return [
          'totalCount' =>$totalCount,
          'newOrderCount' => $newOrderCount,
          'beingProcessedCount' => $beingProcessedCount,
          'shippedCount' => $shippedCount,
          'deliveredCount' => $deliveredCount,
          'cancelledCount' => $cancelledCount,
        ];
    }

    /**
     * @return float
     */
    public function getTotalPayment(){
        $orders = Order::all();
        foreach ($orders as $order){
            $this->total_price += $order->total_price;
        }
        $resultTotalPrice = floatval($this->total_price);
        return $resultTotalPrice;
    }

}




?>
