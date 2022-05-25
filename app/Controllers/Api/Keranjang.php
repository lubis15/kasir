<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Keranjang extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\KeranjangModel';

    function create()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong'
                ]
            ],
            'id_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong'
                ]
            ],
            'jumlah' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong',
                    'numeric' => '{field} Hanya bisa diisi oleh angka'
                ]
            ]
        ])) {
            $response = [
                'error' => true,
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response);
        }

        $produk = new \App\Models\ProdukModel();
        $dataProduk = $produk->find($this->request->getVar('id_produk'));

        $this->model->insert([
            'username' => $this->request->getVar('username'),
            'id_produk' => $this->request->getVar('id_produk'),
            'jumlah' => $this->request->getVar('jumlah'),
            'harga' => $dataProduk->harga,
            'total' => ($dataProduk->harga * $this->request->getVar('jumlah'))
        ]);
        $response = [
            'error' => false,
            'message' => 'Menambah Data Produk Ke Keranjang Berhasil'
        ];
        return $this->respond($response);
    }

    function index()
    {
        $username = $this->request->getVar('username');
        $path = base_url() . "/uploads/produk/";
        $dataKeranjang = $this->model->select("keranjang.*,CONCAT('$path',produk.gambar_produk) as gambar_produk,produk.nama_produk")
            ->join('produk', 'keranjang.id_produk=produk.id_produk')
            ->where(['keranjang.username' => $username])
            ->orderBy('created_at', 'desc')
            ->findAll();

        return $this->respond($dataKeranjang);
    }

    function update($id = NULL)
    {
        if (!$this->validate([
            'jumlah' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                    'numeric' => '{field} Hanya Boleh Berupa Angka'
                ]
            ]
        ])) {
            $response = [
                'error' => true,
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response);
        }


        $data = $this->request->getRawInput();
        $dataKeranjang = $this->model->find($id);

        $produk = new \App\Models\ProdukModel();
        $dataProduk = $produk->find($dataKeranjang->id_produk);
        $totalHarga = $dataProduk->harga * $data['jumlah'];

        $this->model->update($id, [
            'jumlah' => $data['jumlah'],
            'harga' => $dataProduk->harga,
            'total' => $totalHarga
        ]);

        $response = [
            'error' => false,
            'message' => 'Update Data Keranjang Berhasil'
        ];
        return $this->respond($response);
    }

    function delete($id = NULL)
    {
        $dataKeranjang = $this->model->find($id);
        if ($dataKeranjang) {
            $this->model->delete($id);
            $response = [
                'error' => false,
                'message' => 'Data Keranjang Berhasil dihapus'
            ];
            return $this->respond($response);
        } else {
            $response = [
                'error' => true,
                'message' => 'Data Tidak ditemukan'
            ];
            return $this->respond($response);
        }
    }
}
