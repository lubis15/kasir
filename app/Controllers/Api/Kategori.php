<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController{

    protected $format = 'json';
    protected $modelName = 'App\Models\KategoriModel';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

}
