<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Setting;

class GeneralSettingService
{
    protected $setting;
    protected $staticId =1;
    public function __construct(Setting $setting){
        $this->setting = $setting;
    }

    public function getShippedCost(){

        $shippedCost = $this->setting->find(1)->shipping_cost;
        $resultShippedCost = floatval($shippedCost);
        return $resultShippedCost;
    }

}
?>
