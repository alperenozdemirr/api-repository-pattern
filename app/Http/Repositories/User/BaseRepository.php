<?php
namespace App\Http\Repositories\User;

use App\Http\Repositories\User\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        $item = $this->model->find($id);
        $item->update($data);
        return $item;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id){
        $item = $this->model->find($id);
        return $item->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $column
     * @param $condition
     * @return mixed
     */
    public function filter($column, $condition)
    {
        return $this->model->where($column, $condition)->get();
    }
}
?>
