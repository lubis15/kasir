<?php

namespace App\Models;
use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = "keranjang";
    protected $primaryKey = "id_keranjang";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['username','id_produk','jumlah','harga','total'];
}
