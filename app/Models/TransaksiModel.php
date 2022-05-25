<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{

    protected $table = "transaksi";
    protected $primaryKey = "id_transaksi";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id_transaksi', 'no_transaksi', 'username', 'nama_pelanggan', 'no_meja', 'catatan'];

    function noTransaksi($tanggal)
    {
        $transaksi = new TransaksiModel();
        $query = $transaksi->select('MAX(CAST(SUBSTR(no_transaksi,9,4) AS INT)) AS max_no_transaksi')
            ->where('DATE(created_at)', $tanggal)->first();
        if (is_null($query->max_no_transaksi)) {
            $noTransaksi = 1;
        } else {
            $noTransaksi = $query->max_no_transaksi + 1;
        }
        $nextNoTransaksi = str_replace('-', '', $tanggal) . sprintf('%04s', $noTransaksi);
        return $nextNoTransaksi;
    }

    function getMaxIdTransaksiUsers($username)
    {
        $transaksi = new TransaksiModel();
        $dataTransaksi = $transaksi->select('max(id_transaksi) as id_transaksi')
            ->where(['username' => $username])->first();
        return $dataTransaksi->id_transaksi;
    }

    function getChartData()
    {
        $produk = new \App\Models\ProdukModel();
        $dataProduk = $produk->findAll();
        foreach ($dataProduk as $row) {
            $namaProduk[] = $row->nama_produk;
            $jumlahPenjualan[] = $this->getTotalTransaksi($row->id_produk);
        }

        $data = [
            'namaProduk' => $namaProduk,
            'jumlahPenjualan' => $jumlahPenjualan
        ];

        return $data;
    }


    function getTotalTransaksi($idProduk)
    {
        $transaksiDetail = new \App\Models\TransaksiDetailModel();
        $jumlahPenjualan = $transaksiDetail->select('sum(jumlah) as jumlah')
            ->where('transaksi_detail.id_produk', $idProduk)
            ->first();

        return $jumlahPenjualan->jumlah;
    }
}
