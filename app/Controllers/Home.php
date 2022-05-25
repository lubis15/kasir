<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\TransaksiDetailModel;
use App\Models\TransaksiModel;

class Home extends BaseController
{
	public function index()
	{
		$kategori = new KategoriModel();
		$produk = new ProdukModel();
		$transaksiDetail = new TransaksiDetailModel();
		$transaksi = new TransaksiModel();

		$data['kategori'] = $kategori->countAllResults();
		$data['produk'] = $produk->countAllResults();

		$penjualan = $transaksiDetail->select('sum(jumlah) as jumlah,sum(total) as total')->first();
		$data['penjualan'] = $penjualan->jumlah;
		$data['total'] = $penjualan->total;
		$data['grafik'] = $transaksi->getChartData();


		$data['title'] = "Homepage";
		return view('home', $data);
	}

	//--------------------------------------------------------------------

}
