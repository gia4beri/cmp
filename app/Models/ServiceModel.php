<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceModel extends Model
{
    use HasFactory;

    protected $table = 'services';

    public function create($data) : void
    {
        $this->service_name = $data['service_name'];
        $this->service_price = $data['service_price'];
        $this->service_description = $data['service_description'];
        $this->save();
    }

    public function updateService($data)
    {
        $service = ServiceModel::find($data['service_id']);
        $service->service_name = $data['service_name'];
        $service->service_price = $data['service_price'];
        $service->service_description = $data['service_description'];
        $service->save();

    }

    public function remove($data) {
        $this->destroy($data);
    }
}
