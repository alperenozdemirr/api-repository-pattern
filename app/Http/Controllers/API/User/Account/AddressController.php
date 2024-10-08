<?php

namespace App\Http\Controllers\API\User\Account;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\User\AddressRepository;
use App\Http\Requests\User\AddressRequest;
use App\Http\Resources\Public\AddressResource;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * @var AddressRepository
     */
    private $repository = null;

    /**
     * @param AddressRepository $repository
     */
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->filter('user_id',Auth::user()->id);
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => AddressResource::collection($items)],200);
        }
            return ResponseHelper::forbidden();
    }

    /**
     * @param AddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddressRequest $request)
    {
        $items =  $this->repository->create($request->safe()->all());
        if($items){
            return response()->json(['message' => 'The item has been successfully created.','item' => new AddressResource($items)],201);
        }
        return ResponseHelper::failedCreate();

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = $this->repository->authorized($id)->get($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => AddressResource::make($item)],200);
        }
        return ResponseHelper::forbidden();
    }

    /**
     * @param AddressRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AddressRequest $request, $id)
    {
        $item = $this->repository->authorized($id)->update($id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => AddressResource::make($item)],200);
        } else {
            return ResponseHelper::failedUpdate();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->repository->authorized($id)->delete($id);
        if($item){
            return ResponseHelper::successDeleted();
        }
        return ResponseHelper::failedDelete();

    }
}
