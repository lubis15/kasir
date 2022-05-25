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
                <a href="<?= base_url('user/create'); ?>" class="btn btn-primary">Tambah</a>
                <hr />
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $row) {
                            ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $row->username; ?></td>
                                    <td><?= $row->nama; ?></td>
                                    <td><?= $row->level; ?></td>
                                    <td><?= ($row->is_aktif == 1 ? 'Aktif' : 'Tidak Aktif'); ?></td>
                                    <td>
                                        <a data-toggle="tooltip" title="edit" href="<?= base_url("user/edit/$row->username"); ?>" class="btn btn-warning"><i class="far fa-edit"></i></a>

                                        <a data-toggle="tooltip" title="Delete Data" href="<?= base_url("user/delete/$row->username"); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini ? ')"><i class="fas fa-trash"></i></a>
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
                        <?= $pager->links('users', 'bootstrap_pagination'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>