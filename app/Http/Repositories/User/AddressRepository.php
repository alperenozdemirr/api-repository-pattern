<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Address;
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

    public function create(array $data)
    {
        $data['user_id'] = Auth::user()->id;
        return parent::create($data);
    }

}
?>
