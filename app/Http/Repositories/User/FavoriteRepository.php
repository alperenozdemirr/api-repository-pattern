<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class FavoriteRepository extends BaseRepository
{

    public function __construct(Favorite $model = null)
    {
        if($model === null) {
            $model = new Favorite();
        }
        parent::__construct($model);
    }

    public function index(){
        return parent::filter('user_id',Auth::user()->id);
    }
    protected function validateExistence(array $data){
        $item = Product::find($data['product_id']);
        $stock = $item->stock;
        if (empty($item) && $stock != 0) {
            throw new HttpResponseException(
                response()->json(['product' => [
                    "This product with code ". $data['product_id'] ." was not found"
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


}

?>
