<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{

    protected $kategori;

    function __construct()
    {
        $this->kategori = new KategoriModel();
    }


    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $like = [];
        if ($keyword) {
            $like = ['nama_kategori' => $keyword];
        }

        $data['keyword'] = $keyword;
        $data['kategori'] = $this->kategori->like($like)->withDeleted()->paginate($this->perPage, 'kategori');
        $data['pager'] = $this->kategori->pager;
        $data['nomor'] = nomor($this->request->getVar('page_kategori'), $this->perPage);
        $data['title'] = "Data Kategori";
        return view('kategori/index', $data);
    }

    public function create()
    {
        $data['title'] = "Tambah Kategori";
        return view('kategori/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama_kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->kategori->insert([
            'nama_kategori' => $this->request->getVar('nama_kategori')
        ]);
        session()->setFlashdata('message', 'Tambah Data Kategori Berhasil');
        return redirect()->to('/kategori');
    }

    public function edit($id)
    {
        $dataKategori = $this->kategori->find($id);
        if (empty($dataKategori)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Kategori Tidak ditemukan');
        }
        $data['kategori'] = $dataKategori;
        $data['title'] = "Edit Kategori";
        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->kategori->update($id, [
            'nama_kategori' => $this->request->getVar('nama_kategori')
        ]);

        session()->setFlashdata('message', 'Update Data Kategori Berhasil');
        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        $dataKategori = $this->kategori->find($id);
        if (empty($dataKategori)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Kategori Tidak ditemukan !');
        }
        $this->kategori->delete($id);
        session()->setFlashdata('message', 'Delete Data Kategori Berhasil');
        return redirect()->to('/kategori');
    }

    public function restore($id)
    {
        $dataKategori = $this->kategori->withDeleted()->find($id);
        if (empty($dataKategori)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Kategori Tidak ditemukan !');
        }
        $this->kategori->update($id, ['deleted_at' => NULL]);
        session()->setFlashdata('message', 'Restore Data Berhasil !');
        return redirect()->to('/kategori');
    }

    public function permanentdelete($id)
    {
        $dataKategori = $this->kategori->withDeleted()->find($id);
        if (empty($dataKategori)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Kategori Tidak ditemukan !');
        }
        $this->kategori->delete($id, true);
        session()->setFlashdata('message', 'Delete Data Secara Permanent Berhasil !');
        return redirect()->to('/kategori');
    }

    //--------------------------------------------------------------------

}
