<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Product;

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
