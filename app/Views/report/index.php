<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3><?= $title; ?></h3>
            </div>
            <div class="card-body">
                <form method="get" action="">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="tglawal" value="<?= $tglAwal; ?>" placeholder="Tanggal Awal" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="tglakhir" value="<?= $tglAkhir; ?>" placeholder="Tanggal Akhir" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Cari</button>
                                <button type="submit" target="_blank" formaction="<?= base_url('report/exportpdf'); ?>" class="btn btn-danger">PDF</button>
                                <button type="submit" target="_blank" formaction="<?= base_url('report/exportexcel'); ?>" class="btn btn-success">EXCEL</button>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Kasir</th>
                                <th>Nama Pelanggan</th>
                                <th>No Meja</th>
                                <th>Catatan</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($report as $row) {
                            ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $row->no_transaksi; ?></td>
                                    <td><?= tanggal($row->tanggal_transaksi); ?></td>
                                    <td><?= $row->nama; ?></td>
                                    <td><?= $row->nama_pelanggan; ?></td>
                                    <td><?= $row->no_meja; ?></td>
                                    <td><?= $row->catatan; ?></td>
                                    <td><?= rupiah($row->total); ?></td>
                                    <td>
                                        <a data-toggle="tooltip" title="Detail" href="<?= base_url("report/detail/$row->id_transaksi"); ?>" class="btn btn-primary"><i class="fas fa-search"></i></a>
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
                        <?php echo $pager->links('transaksi', 'bootstrap_pagination') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>