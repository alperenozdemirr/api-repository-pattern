<?php

namespace App\Http\Controllers\API\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LogFilterRequest;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $log = Activity::paginate(25);
        if ($log){
            return  response()->json([
                'message'=> 'Log data have been listed successfully' ,
                'log'=> $log
            ],200);
        }

        return response()->json(['message' => 'The item could not be found'],404);
    }

    /**
     * @param LogFilterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(LogFilterRequest $request){
        if (empty($request->safe()->all())){
            $log = Activity::paginate(25);
        } else {
            $log = Activity::when($request->filled('operation_name'), function ($query) use ($request) {
                return $query->where('log_name', 'like', '%' . $request->input('operation_name') . '%');
            })->when($request->filled('operation_type'), function ($query) use ($request) {
                    return $query->where('description', 'like', '%' . $request->input('operation_type') . '%');
            })->when($request->filled('user'), function ($query) use ($request) {
                    return $query->where('causer_id', $request->input('user'));
            })
            ->paginate(25);
        }
        if ($log){
         return  response()->json([
             'message'=> 'Log data have been listed successfully' ,
             'log'=> $log
         ],200);
        }
        return response()->json(['message' => 'The item could not be found'],404);
    }
}
