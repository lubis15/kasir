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
                <form method="post" action="<?= base_url('kategori/update/' . $kategori->id_kategori); ?>">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="<?= $kategori->nama_kategori; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>