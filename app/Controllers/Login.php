<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    protected $users;

    function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/home');
        }
        return view('login');
    }

    public function proses()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $dataUser = $this->users->where([
            'username' => $username,
            'level' => 'admin',
            'is_aktif' => '1'
        ])->first();
        if ($dataUser) {
            if (password_verify($password, $dataUser->password)) {
                $this->session->set([
                    'username' => $dataUser->username,
                    'nama' => $dataUser->nama,
                    'level' => $dataUser->level,
                    'logged_in' => TRUE
                ]);
                return redirect()->to('/home');
            } else {
                session()->setFlashdata('error', 'Username & Password Tidak Sesuai');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Username & Password Tidak Sesuai');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    //--------------------------------------------------------------------

}
