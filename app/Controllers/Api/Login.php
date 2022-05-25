<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\UsersModel';

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $dataUser = $this->model->where([
            'username'=>$username,
            'is_aktif'=>'1',
            'level !='=>'admin'
        ])->first();
        if($dataUser)
        {
            if(password_verify($password,$dataUser->password))
            {
                $response = [
                    'error'=>false,
                    'data'=>$dataUser,
                    'message'=>'Login Berhasil'
                ];
                return $this->respond($response);
            }
            else
            {
                $response = [
                    'error'=>true,
                    'message'=>'Username & Password Tidak ditemukan'
                ];
                return $this->respond($response);
            }
        }
        else
        {
           $response = [
               'error'=>true,
               'message'=>'Username tidak ditemukan'
           ];
           return $this->respond($response);
        }
    }
}
