<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{

    protected $table = "transaksi_detail";
    protected $primaryKey = "id_transaksi_detail";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id_transaksi', 'id_produk', 'jumlah', 'harga', 'total'];
}
