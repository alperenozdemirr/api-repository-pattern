<?php

namespace App\Http\Controllers\API\User\Account;

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
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
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
        } else {
            return response()->json(['error' => 'Failed to created the item'],422);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = $this->repository->get($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => AddressResource::make($item)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
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
            return response()->json(['error' => 'Failed to updated the item'],422);
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
            return response()->json(['message' => 'Items have been item deleted']);
        }
        return response()->json(['error' => 'Failed to delete the item'],400);

    }
}
