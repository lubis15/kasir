<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3><?= $title; ?></h3>
            </div>
            <div class="card-body">
                <?= $this->include('alert/error'); ?>
                <form method="post" action="<?= base_url('produk/store'); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="<?= old('nama_produk'); ?>">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-control">
                            <?php
                            foreach ($kategori as $row) {
                                echo "<option value='$row->id_kategori'>$row->nama_kategori</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga" id="harga" value="<?= old('harga'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="gambar_produk">Gambar Produk</label>
                        <input type="file" class="form-control" name="gambar_produk" id="gambar_produk">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>