<?php
// contoh ambil data dari database
$total_penjualan = $lihat->total_penjualan_bulan_ini();
$total_produksi = $lihat->total_produksi_bulan_ini();
$total_produksiTon = $lihat->total_produksi_bulan_ini_per_ton();
$stok_bahanbaku_kritis = $lihat->jumlah_bahanbaku_kritis();
$po_dalam_proses = $lihat->jumlah_po_dalam_proses();
$grafikPerBulan = $lihat->grafikPerBulan();

$labels = [];
$totals = [];
$total_qty = [];
foreach ($grafikPerBulan as $row) {
    $labels[] = $row['bulan']; // Format seperti: Jul 2025
    $totals[] = $row['total'];
    $total_qty[] = $row['total_qty'];
}
// var_dump($labels, $totals);


$total_ppn_bulan_ini = $lihat->total_ppn_bulan_ini();
$jumlah_ppn_bulan_ini = $lihat->jumlah_ppn_bulan_ini();
$jumlah_bulan_ini = $lihat->jumlah_bulan_ini();
$total_ongkir_bulan_ini = $lihat->total_ongkir_bulan_ini();
$jumlah_ongkir_gratis = $lihat->jumlah_ongkir_gratis();
$jumlah_ongkir_bulan_ini = $lihat->jumlah_ongkir_bulan_ini();
$jatuhTempo = $lihat->pembayaran_jatuh_tempo();
// var_dump($total_ppn_bulan_ini);
// var_dump($jumlah_ppn_bulan_ini);
// var_dump($jumlah_bulan_ini);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Penjualan Bulan Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Penjualan Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produksi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Produksi Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_produksiTon ?> Ton dari <?= $total_produksi ?> Order</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-industry fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bahan Baku Kritis -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stok Bahan Baku Kritis</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stok_bahanbaku_kritis ?> Item</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PO Dalam Proses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bahan Baku Dalam Proses Order</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $po_dalam_proses ?> PO</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Total Penjualan Bulan Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total PPN Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_ppn_bulan_ini, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-landmark fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produksi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Penjualan dengan PPN Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_ppn_bulan_ini ?> dari <?= $jumlah_bulan_ini ?> Order</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bahan Baku Kritis -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ongkir Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_ongkir_bulan_ini, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PO Dalam Proses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Gratis Ongkir dari Order Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= $jumlah_ongkir_gratis ?> dari <?= $jumlah_ongkir_bulan_ini ?> Order</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row Chart (opsional) -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan per Bulan</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartPenjualan"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Client Order Jatuh Tempo (H-7)</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($jatuhTempo as $row): ?>
                            <div class="col-md-12">
                                <div class="card shadow-sm mb-3 border-left-<?= $row['total_jatuh_tempo'] > 0 ? 'danger' : 'warning' ?>">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2"><?= $row['nama_client'] ?></h5>
                                        <p class="mb-1">
                                            <span class="text-danger">🛑 Order Sudah Jatuh Tempo:</span> <strong><?= $row['total_jatuh_tempo'] ?> Order</strong><br>
                                            <span class="text-muted">💰 Tagihan:</span> <strong>Rp <?= number_format($row['tagihan_jatuh_tempo'], 0, ',', '.') ?></strong>
                                        </p>
                                        <p class="mb-0">
                                            <span class="text-warning">⚠️ Order Segera Jatuh Tempo:</span> <strong><?= $row['total_segera_jatuh_tempo'] ?> Order</strong><br>
                                            <span class="text-muted">💰 Tagihan:</span> <strong>Rp <?= number_format($row['tagihan_segera_jatuh_tempo'], 0, ',', '.') ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Contoh data statis
    const ctxPenjualan = document.getElementById('chartPenjualan');
    const penjualanChart = new Chart(ctxPenjualan, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [{
                    label: 'Total Penjualan',
                    data: <?= json_encode($totals); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Quantity',
                    data: <?= json_encode($total_qty); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let val = context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            return 'Rp ' + val;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            }
        }
    });

    const ctxCompare = document.getElementById('chartProduksiPenjualan');
    const chartCompare = new Chart(ctxCompare, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                    label: 'Produksi (Ton)',
                    data: [120, 130, 110, 140, 150, 135],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                },
                {
                    label: 'Penjualan (Ton)',
                    data: [100, 115, 105, 130, 140, 120],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)'
                }
            ]
        }
    });
</script>