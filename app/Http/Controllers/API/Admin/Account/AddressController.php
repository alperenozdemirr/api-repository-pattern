<?php

namespace App\Http\Controllers\API\Admin\Account;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\AddressRepository;
use App\Http\Resources\Public\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    private $repository = null;
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
            return response()->json(['message' => 'Items have been listed successfully','items' => AddressResource::collection($items)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
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
            return response()->json(['message' => 'Items have been listed successfully','item' => AddressResource::make($item)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->repository->delete($id);
        if($item){
            return response()->json(['message' => 'Items have been item deleted']);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }

}
