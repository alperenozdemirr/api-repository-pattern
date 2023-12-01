<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\ShoppingCart;

class ShoppingCartRepository extends BaseRepository
{
    public function __construct(ShoppingCart $model = null)
    {
        if($model === null) {
            $model = new ShoppingCart();
        }
        parent::__construct($model);
    }

}






?>
