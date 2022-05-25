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
                <form method="post" action="<?= base_url('user/update/' . $users->username); ?>">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" disabled value="<?= $users->username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $users->nama; ?>">
                    </div>

                    <div class="form-group">
                        <label for="level">Level</label>
                        <select name="level" id="level" class="form-control">
                            <option value="admin" <?= ($users->level == "admin" ? 'Selected' : ''); ?>>Admin</option>
                            <option value="kasir" <?= ($users->level == "kasir" ? 'Selected' : ''); ?>>Kasir</option>
                            <option value="owner" <?= ($users->level == "owner" ? 'Selected' : ''); ?>>Owner</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="is_aktif">Status Aktif</label>
                        <select name="is_aktif" id="is_aktif" class="form-control">
                            <option value="1" <?= ($users->is_aktif == "1" ? 'Selected' : ''); ?>>Aktif</option>
                            <option value="0" <?= ($users->is_aktif == "0" ? 'Selected' : ''); ?>>Tidak Aktif</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Update</button>
                </form>


            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>