<?php

namespace App\Http\Controllers\API\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\DashboardRepository;


class DashboardController extends Controller
{

    protected $repository = null;

    /**
     * @param DashboardRepository $repository
     */
    public function __construct(DashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $data = null;
        $items = $this->repository->index($data);
        if($items){
            return response()->json(['message' => 'Item data have been listed successfully','Dashboard' => $items],200);
        }
        return response()->json(['message' => 'The item could not be found'],404);
    }
}
