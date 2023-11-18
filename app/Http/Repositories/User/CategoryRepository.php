<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Category;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRepository extends BaseRepository
{

    public function __construct(Category $model = null)
    {
        if($model === null) {
            $model = new Category();
        }
        parent::__construct($model);
    }

}
?>
