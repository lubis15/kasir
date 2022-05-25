<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{

    protected $users;

    function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        $data['title'] = "Data Users";
        $data['users'] = $this->users->paginate($this->perPage, 'users');
        $data['pager'] = $this->users->pager;
        $data['nomor'] = nomor($this->request->getVar('page_users'), $this->perPage);
        return view('users/index', $data);
    }

    public function create()
    {
        $data['title'] = "Tambah Users";
        return view('users/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required|is_unique[users.username]|max_length[255]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'is_unique' => 'Username telah digunakan, gunakan username lainnya',
                    'max_length' => 'Maksimal 255 Karakter'
                ]
            ],
            'nama' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'max_length' => 'Maksimal 255 Karakter'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->users->insert([
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'nama' => $this->request->getVar('nama'),
            'level' => $this->request->getVar('level'),
            'is_aktif' => $this->request->getVar('is_aktif')
        ]);

        session()->setFlashdata('message', 'Tambah Data Users Berhasil');
        return redirect()->to('/user');
    }

    public function edit($username)
    {
        $dataUsers = $this->users->find($username);
        if (empty($dataUsers)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data User tidak ditemukan !!');
        }
        $data['users'] = $dataUsers;
        $data['title'] = "Edit Users";
        return view('users/edit', $data);
    }

    function update($username)
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'max_length' => '{field} Maksimal 255 Karakter'
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back();
        }

        $data = [
            'nama' => $this->request->getVar('nama'),
            'level' => $this->request->getVar('level'),
            'is_aktif' => $this->request->getVar('is_aktif')
        ];

        if (!empty($this->request->getVar('password'))) {
            $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
        }

        $this->users->update($username, $data);
        session()->setFlashdata('message', 'Update Data Berhasil');
        return redirect()->to('/user');
    }

    public function delete($username)
    {
        $dataUsers = $this->users->find($username);
        if (empty($dataUsers)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data User Tidak Ditemukan !!');
        }
        $this->users->delete($username);
        session()->setFlashdata('message', 'Delete Data Berhasil dilakukan');
        return redirect()->to('/user');
    }

    //--------------------------------------------------------------------

}
