<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3><?= $title; ?></h3>
            </div>
            <div class="card-body">
                <a href="<?= base_url('produk/create'); ?>" class="btn btn-primary">Tambah</a>
                <hr />
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" id="kategori" class="form-control">
                                <option value="all">- Seluruh Kategori -</option>
                                <?php
                                foreach ($kategori as $row) {
                                ?>
                                    <option value="<?= $row->id_kategori; ?>" <?= ($row->id_kategori == $id_kategori ? 'Selected' : ''); ?>><?= $row->nama_kategori; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Search</label>
                            <input type="text" id="keyword" name="keyword" class="form-control" value="<?= $keyword; ?>">
                        </div>
                    </div>

                </div>
                <?= $this->include('alert/success'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        foreach ($produk as $row) {
                        ?>
                            <tr>
                                <td><?= $nomor++; ?></td>
                                <td><?= $row->nama_produk; ?></td>
                                <td><?= $row->nama_kategori; ?></td>
                                <td><?= rupiah($row->harga); ?></td>
                                <td><img class="rounded" width="200px" src="<?= $row->gambar_produk; ?>" /></td>
                                <td>
                                    <?php
                                    if (!is_null($row->deleted_at)) {
                                        echo '<span class="badge badge-danger">Trash</span>';
                                    } else {
                                        echo '<span class="badge badge-primary">Aktif</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!is_null($row->deleted_at)) {
                                    ?>
                                        <a data-toggle="tooltip" title="Restore" href="<?= base_url("produk/restore/$row->id_produk"); ?>" class="btn btn-success"><i class="fas fa-trash-restore"></i></a>

                                        <a data-toggle="tooltip" title="Permanent Delete" href="<?= base_url("produk/permanentdelete/$row->id_produk"); ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data secara permanent ?')"><i class="fas fa-ban"></i></a>
                                    <?php

                                    } else {
                                    ?>

                                        <a data-toggle="tooltip" title="Edit" href="<?= base_url("produk/edit/$row->id_produk"); ?>" class="btn btn-warning"><i class="far fa-edit"></i></a>
                                        <a data-toggle="tooltip" title="Delete Data" href="<?= base_url("produk/delete/$row->id_produk"); ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ?')"><i class="fas fa-trash"></i></a>

                                    <?php
                                    }
                                    ?>


                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="row mt-3 float-right">
                    <div class="col-md-12">
                        <?php echo $pager->links('produk', 'bootstrap_pagination') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        $("#kategori").change(function() {
            filter();
        });

        $("#keyword").keypress(function(event) {
            if (event.keyCode == 13) {
                filter();
            }
        });

        var filter = function() {
            var kategori = $("#kategori").val();
            var keyword = $("#keyword").val();
            window.location.replace("/produk?kategori=" + kategori + "&keyword=" + keyword);
        }
    });
</script>
<?= $this->endSection('scripts'); ?>