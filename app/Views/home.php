<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3><?= $title; ?></h3>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= $kategori; ?></h3>
                                <p>Kategori Produk</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-archive"></i>
                            </div>
                            <a href="/kategori" class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= $produk; ?></h3>
                                <p>Produk</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/produk" class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?= $penjualan; ?></h3>
                                <p>Produk Terjual</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="/report" class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= rupiah($total); ?></h3>
                                <p>Total Penjualan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="/report" class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i> Grafik Penjualan
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="grafikPenjualan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url('assets/chart/Chart.min.js'); ?>"></script>
<script src="<?= base_url('assets/chart/utils.js'); ?>"></script>

<script>
    var ctx = document.getElementById("grafikPenjualan").getContext('2d');
    ctx.height = 500;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($grafik['namaProduk']); ?>,
            datasets: [{
                label: 'Grafik Penjualan',
                data: <?= json_encode($grafik['jumlahPenjualan']); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255,99,132,1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</script>


<?= $this->endSection('scripts'); ?>