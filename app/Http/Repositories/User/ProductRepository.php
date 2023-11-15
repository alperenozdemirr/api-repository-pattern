<?php
namespace App\Http\Repositories\User;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductRepository extends BaseRepository
{

    public function __construct(Product $model = null)
    {
        if($model === null) {
            $model = new Product();
        }
        parent::__construct($model);
    }

}
?>
