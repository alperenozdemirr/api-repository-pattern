<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CommentRepository extends BaseRepository
{

    public function __construct(Comment $model = null)
    {
        if($model === null) {
            $model = new Comment();
        }
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $data['user_id'] = Auth::user()->id;
        $item = Product::find($data['product_id']);
        if (empty($item)) {
            throw new HttpResponseException(
                response()->json(['product_id' => [
                    "This product with code ". $data['product_id'] ." was not found"
                ]], 422)
            );
        }
        return parent::create($data);
    }


}
?>
