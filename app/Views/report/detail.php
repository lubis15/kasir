<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3><?= $title; ?></h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td width="200px;">Kasir</td>
                        <td width="10px;">:</td>
                        <td><?= $transaksi->nama; ?></td>
                    </tr>
                    <tr>
                        <td width="200px;">No Transaksi</td>
                        <td width="10px;">:</td>
                        <td><?= $transaksi->no_transaksi; ?></td>
                    </tr>
                    <tr>
                        <td width="200px;">No Meja</td>
                        <td width="10px;">:</td>
                        <td><?= $transaksi->no_meja; ?></td>
                    </tr>
                    <tr>
                        <td width="200px;">Nama Pelanggan</td>
                        <td width="10px;">:</td>
                        <td><?= $transaksi->nama_pelanggan; ?></td>
                    </tr>
                    <tr>
                        <td width="200px;">Catatan</td>
                        <td width="10px;">:</td>
                        <td><?= $transaksi->catatan; ?></td>
                    </tr>
                </table>
                <hr />
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        $total = 0;
                        foreach ($detail as $row) {
                        ?>
                            <tr>
                                <td><?= $nomor++; ?></td>
                                <td><?= $row->nama_produk; ?></td>
                                <td><?= $row->jumlah; ?></td>
                                <td><?= rupiah($row->harga); ?></td>
                                <td><?= rupiah($row->total); ?></td>
                            </tr>
                        <?php
                            $total = $total + $row->total;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Total</td>
                            <td><?= rupiah($total); ?></td>
                        </tr>
                    </tfoot>
                </table>
                <hr />
                <a href="/report" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>