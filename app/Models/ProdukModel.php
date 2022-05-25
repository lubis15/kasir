<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = "produk";
    protected $primaryKey = "id_produk";
    protected $returnType = 'App\Entities\Produk';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_kategori', 'nama_produk', 'gambar_produk', 'harga', 'deleted_at'];
}
