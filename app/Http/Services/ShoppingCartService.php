<?php

namespace App\Http\Services;


use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Auth;

class ShoppingCartService
{
    protected $itemAmount = 0;
    protected $totalPrice = 0.00;
    protected $baskets;
    public function __construct(ShoppingCart $baskets){
        $this->baskets = $baskets;
    }

    public function getTotalPrice(){
        $baskets = $this->baskets->where('user_id',Auth::user()->id)->get();
        foreach ($baskets as $basket){
            $this->totalPrice += $basket->amount * $basket->product->discount_price;
        }
        $resultTotalPrice = floatval($this->totalPrice);
        return  $resultTotalPrice;
    }

    public function getTotalProductAmount(){
        $this->itemAmount = $this->baskets->where('user_id', Auth::user()->id)->distinct('product_id')->count();
        return $this->itemAmount;
    }
}





?>
