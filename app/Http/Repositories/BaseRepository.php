<?php
namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class BaseRepository implements RepositoryInterface
{
    protected $isAutorized;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return void
     */
    protected function validateExistenceId($id){
        $item = $this->model->find($id);
        if (empty($item)) {
            throw new HttpResponseException(
                response()->json(['message' => [
                    "The item could not be found."
                ]], 404)
            );
        }
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
     * @return mixed
     */
    public function all()
    {
        return $this->model->orderByDesc('id')->get();
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
        $this->validateExistenceId($id);
        $item = $this->model->find($id);
        $item->update($data);
        return $item;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id){
        if((!empty($this->isAutorized)) && ($this->isAutorized == true)){
            $item = $this->model->find($id);
            return $item->delete();
        }
        $this->validateExistenceId($id);
        $item = $this->model->find($id);
        return $item->delete();
    }

    public function authorized($id){
        $this->validateExistenceId($id);
        $item = $this->model->find($id);
        if ($item){
            if (!empty($item) && $item->user_id == Auth::user()->id)
            {
                $this->isAutorized = true;
                return $this;
            }
            throw new HttpResponseException(
                response()->json(['error' => [
                    "Unauthorized access to this data."
                ]], 401)
            );
        }
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
    public function filter($column = null, $condition = null)
    {
        if ($column == null && $condition == null){
            return $this->model->orderByDesc('id')->paginate(20);
        }else{
            return $this->model->where($column, $condition)->orderByDesc('id')->paginate(20);
        }

    }
}
?>
