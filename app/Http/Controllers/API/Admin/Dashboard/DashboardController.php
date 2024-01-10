<?php

namespace App\Http\Controllers\API\Admin\Dashboard;

use App\Enums\ShipmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DashboardResource;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\UserType;
use App\Enums\Status;

class DashboardController extends Controller
{
    protected $total_price = 0.00;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $orders = Order::all();
        foreach ($orders as $order){
            $this->total_price += $order->total_price;
        }
        $resultTotalPrice = floatval($this->total_price);

        $data['userTotalCount'] = User::count();
        $data['userActiveCount'] = User::where('status',Status::ACTIVE)->count();
        $data['userPassiveCount'] = User::where('status',Status::PASSIVE)->count();
        $data['adminCount'] = User::where('type',UserType::ADMIN)->count();

        $data['productTotalCount'] = Product::count();
        $data['basketTotalCount'] = ShoppingCart::count();
        $data['favoriteTotalCount'] = Favorite::count();

        $data['orderAllCount'] = Order::count();
        $data['newOrders'] = Order::where('shipment_status',ShipmentStatus::ORDER_RECEIVED)->count();
        $data['beingProcessedOrders'] = Order::where('shipment_status',ShipmentStatus::BEING_PROCESSED)->count();
        $data['shippedOrders'] = Order::where('shipment_status',ShipmentStatus::SHIPPED)->count();
        $data['deliveredOrders'] = Order::where('shipment_status',ShipmentStatus::DELIVERED)->count();
        $data['cancelledOrders'] = Order::where('shipment_status',ShipmentStatus::CANCELLED)->count();
        $data['totalPayment'] = $resultTotalPrice;
        $data = collect($data);
        if($data){
            return response()->json(['message' => 'Item data have been listed successfully','Dashboard' => $data],200);
        }
        return response()->json(['message' => 'The item could not be found'],404);

    }
}
