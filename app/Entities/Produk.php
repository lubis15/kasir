<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Produk extends Entity
{
    public function getGambarProduk()
    {
        $this->attributes['gambar_produk'] = base_url()."/uploads/produk/".$this->attributes['gambar_produk'];
        return $this->attributes['gambar_produk'];
    }
}
