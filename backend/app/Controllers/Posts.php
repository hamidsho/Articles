<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostModel;

use function PHPUnit\Framework\returnSelf;

class Posts extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;

    public function show($status = null)
    {
        $model = new PostModel();
        $data = $model->where(['status' => $status])
            ->findAll();


        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data Tidak Ditemukan');
        }
    }
}
