<style type="text/css">
    table,
    td,
    th {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>
<h3 style="text-align: center;"><?= $title; ?></h3>
<hr />
<table border="1" width="100%">
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
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        $total = 0;
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
            </tr>
        <?php
            $total = $total + $row->total;
        }
        ?>
        <tr>
            <td colspan="7" style="text-align: center;"> Total </td>
            <td><?= rupiah($total); ?></td>
        </tr>
    </tbody>
</table>