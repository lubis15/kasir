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
                <form method="post" action="<?= base_url("produk/update/$produk->id_produk"); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="<?= $produk->nama_produk; ?>">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-control">
                            <?php
                            foreach ($kategori as $row) {
                            ?>
                                <option value="<?= $row->id_kategori; ?>" <?= ($row->id_kategori == $produk->id_kategori ? 'Selected' : ''); ?>><?= $row->nama_kategori; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga" id="harga" value="<?= $produk->harga; ?>">
                    </div>


                    <div class="form-group">
                        <label></label>
                        <img src="<?= $produk->gambar_produk; ?>" class="rounded" width="150px" />
                    </div>

                    <div class="form-group">
                        <label for="gambar_produk">Gambar Produk</label>
                        <input type="file" class="form-control" name="gambar_produk" id="gambar_produk">
                    </div>


                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>