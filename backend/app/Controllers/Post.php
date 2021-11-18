<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostModel;
use CodeIgniter\I18n\Time;

use function PHPUnit\Framework\returnSelf;

class Post extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {

        $model = new PostModel();
        $data = $model->findAll();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data Tidak Ditemukan');
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new PostModel();
        $data = $model->find(['id' => $id]);
        if ($data) {
            return $this->respond($data[0]);
        } else {
            return $this->failNotFound('Data Tidak Ditemukan');
        }
    }


    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {


        $rules = [
            "title" => "required|min_length[20]",
            "content" => "required|min_length[200]",
            "category" => "required|min_length[3]"
        ];
        $messages = [
            "title" => [
                "required" => "Title is required"
            ],
            "content" => [
                "required" => "Content is required"
            ],
            "category" => [
                "required" => "Category is required"
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {

            $emp = new PostModel();
            $json = $this->request->getJSON();


            $data = [
                'title' => $json->title,
                'content' => $json->content,
                'category' => $json->category,
                'created_date' => new Time('now'),
                'updated_date' => "",
                'status' => $json->status
            ];

            $post = $emp->insert($data);
        }
        return $this->respondCreated($post);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {

        $rules = [
            "title" => "required|min_length[20]",
            "content" => "required|min_length[200]",
            "category" => "required|min_length[3]",
            "status" => "required"
        ];
        $messages = [
            "title" => [
                "required" => "Title is required"
            ],
            "content" => [
                "required" => "Content is required"
            ],
            "category" => [
                "required" => "Category is required"
            ],
            "status" => [
                "required" => "Status is required"
            ],
        ];

        if (!$this->validate($rules, $messages)) {

            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {

            $emp = new PostModel();


            $json = $this->request->getJSON();
            if ($emp->find($id)) {
                $data = [
                    'title' => $json->title,
                    'content' => $json->content,
                    'category' => $json->category,
                    'updated_date' => new Time('now'),
                    'status' => $json->status
                ];
                $emp->update($id, $data);
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Post updated successfully',
                    'data' => []
                ];
            } else {

                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => 'No employee found',
                    'data' => []
                ];
            }
        }
        return $this->respondCreated($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new PostModel();
        $cekId = $model->find(['id' => $id]);
        if (!$cekId) return $this->fail('Data Tidak ditemukan', 404);
        $data = [
            'status' => "Trash"
        ];
        $post = $model->update($id, $data);
        if (!$post) return $this->fail('Gagal terhapus', 400);
        return $this->respondDeleted('Data berhasil terhapus');
    }
}
