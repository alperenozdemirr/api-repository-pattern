<?php

namespace App\Http\Controllers\API\Admin\Setting;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\GeneralSettingRepository;
use App\Http\Requests\Admin\UpdateGeneralSettingRequest;
use App\Http\Resources\Admin\GeneralSettingResource;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    private $repository = null;

    /**
     * @param GeneralSettingRepository $repository
     */
    public function __construct(GeneralSettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $item= $this->repository->find(1);
        if($item){
            return response()->json(['message' => 'General Setting data have been listed successfully','items' => GeneralSettingResource::collection($item)],200);
        }
        return ResponseHelper::forbidden();

    }

    /**
     * @param UpdateGeneralSettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateGeneralSettingRequest $request){
        $item = $this->repository->updateV2($request->safe()->all());

        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => GeneralSettingResource::make($item)],200);
        }
        return ResponseHelper::failedUpdate();
    }
}
