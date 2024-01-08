<?php
namespace App\Http\Repositories\Admin;

use App\Http\Repositories\BaseRepository;
use App\Http\Services\FileService;
use App\Models\Setting;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeneralSettingRepository extends BaseRepository
{
    public function __construct(Setting $model = null)
    {
        if($model === null) {
            $model = new Setting();
        }
        parent::__construct($model);
    }

    /**
     * @param $data
     * @return void
     */
    protected function validateExistence($data){
        $errors = [];
        if (empty($data['shipping_cost'])) {
            $errors[] = "This item with code 'shipping_cost' was not found";
        }
        if (empty($data['website_name'])) {
            $errors[] = "This item with code 'website_name' was not found";
        }
        if (!empty($errors)) {
            throw new HttpResponseException(
                response()->json(['item' => $errors], 422)
            );
        }

    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function updateV2(array $data)
    {
        $staticId = 1;
        $setting = $this->model->find($staticId);
        if ($setting){
            return parent::update($staticId,$data);
        }
        $this->validateExistence($data);
        return parent::create($data);
    }
}






?>
