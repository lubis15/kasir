<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3><?= $title; ?></h3>
            </div>
            <div class="card-body">
                <?= $this->include('alert/success'); ?>
                <a href="<?= base_url('kategori/create'); ?>" class="btn btn-primary">Tambah</a>
                <hr />
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Masukkan Keyword Pencarian" name="keyword" value="<?= $keyword; ?>" />
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" name="submit">Search</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($kategori as $row) {
                            ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $row->nama_kategori; ?></td>
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
                                            <a href="<?= base_url("kategori/restore/$row->id_kategori"); ?>" data-toggle="tooltip" title="Restore" class="btn btn-success"><i class="fas fa-trash-restore"></i></a>

                                            <a href="<?= base_url("kategori/permanentdelete/$row->id_kategori"); ?>" data-toggle="tooltip" title="Permanent Delete" class="btn btn-danger" onclick="return confirm('Apakah anda yakin menghapus data secara permanent ?')"><i class="fas fa-ban"></i></a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="<?= base_url("kategori/edit/$row->id_kategori"); ?>" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="far fa-edit"></i></a>

                                            <a href="<?= base_url("kategori/delete/$row->id_kategori"); ?>" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="return confirm('Apakah anda yakin menghapus data ?')"><i class="fas fa-trash"></i></a>
                                        <?php
                                        }
                                        ?>


                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                    </table>

                </div>

                <div class="row mt-3 float-right">
                    <div class="col-md-12">
                        <?php echo $pager->links('kategori', 'bootstrap_pagination') ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>