<?php
namespace App\Http\Repositories\Admin;


use App\Http\Repositories\BaseRepository;
use App\Http\Services\DashboardService;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DashboardRepository extends BaseRepository
{
    protected $dashboardService = null;

    /**
     * @param DashboardService $dashboardService
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * @param $data
     * @return array
     */
    public function index($data){
         $data = [
            'userStats' => $this->dashboardService->getUserStats(),
            'productStats' => $this->dashboardService->getProductStats(),
            'basketStats' => $this->dashboardService->getBasketStats(),
            'favoriteStats' => $this->dashboardService->getFavoriteStats(),
            'orderStats' => $this->dashboardService->getOrderStats(),
            'total_payment' => $this->dashboardService->getTotalPayment(),
        ];
        return $data;
    }
}


?>
