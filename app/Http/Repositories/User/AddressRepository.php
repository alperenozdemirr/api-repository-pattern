<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Address;
use App\Models\City;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class AddressRepository extends BaseRepository
{

    public function __construct(Address $model = null)
    {
        if($model === null) {
            $model = new Address();
        }
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return void
     */
    protected function validateExistence(array $data){
        $item = City::where('code',$data['city_code'])->first();
        if (empty($item)) {
            throw new HttpResponseException(
                response()->json(['city_code' => [
                    "This city with code ". $data['city_code'] ." was not found"
                ]], 422)
            );
        }
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $this->validateExistence($data);

        $data['user_id'] = Auth::user()->id;
        return parent::create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        $this->validateExistence($data);

        return parent::update($id, $data);
    }

}
?>
