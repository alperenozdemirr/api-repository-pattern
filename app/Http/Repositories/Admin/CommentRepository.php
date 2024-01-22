<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    public function __construct(Comment $model = null)
    {
        if($model === null) {
            $model = new Comment();
        }
        parent::__construct($model);
    }

}
?>
