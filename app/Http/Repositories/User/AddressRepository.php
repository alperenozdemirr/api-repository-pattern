<?php
namespace App\Http\Repositories\User;

use App\Models\Address;

class AddressRepository extends BaseRepository
{

    public function __construct(Address $model = null)
    {
        if($model === null) {
            $model = new Address();
        }
        parent::__construct($model);
    }

}
?>
