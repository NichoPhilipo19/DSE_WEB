<div class="card mb-3">
    <div id="cardHeaderFilter" class="card-header bg-primary text-white " style="cursor:pointer;">
        <strong><i class="fas fa-filter"></i> Filter Laporan</strong>
    </div>

    <div id="filterCard" class="collapse show">
        <div class="card-body">
            <form method="GET" id="filterForm">
                <input type="hidden" name="page" value="laporancoba">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Jenis Laporan</label>
                        <select id="jenisLaporan" name="jenis" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="penjualan product" <?= ($_GET['jenis'] ?? '') === 'penjualan product' ? 'selected' : '' ?>>Penjualan Product</option>
                            <option value="pembelian" <?= ($_GET['jenis'] ?? '') === 'pembelian' ? 'selected' : '' ?>>Pembelian Bahan Baku</option>
                            <option value="produksi" <?= ($_GET['jenis'] ?? '') === 'produksi' ? 'selected' : '' ?>>Stock Bahan Baku</option>
                            <option value="piutang" <?= ($_GET['jenis'] ?? '') === 'piutang' ? 'selected' : '' ?>>Piutang</option>
                            <option value="piutang" <?= ($_GET['jenis'] ?? '') === 'piutang' ? 'selected' : '' ?>>Uang Jalan Supir</option>
                            <option value="piutang" <?= ($_GET['jenis'] ?? '') === 'piutang' ? 'selected' : '' ?>>Pemasukan & Pengeluaran</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Dari Tanggal</label>
                        <input id="from" type="date" name="tgl_dari" class="form-control" required value="<?= $_GET['tgl_dari'] ?? date('Y-m-01') ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Sampai Tanggal</label>
                        <input id="to" type="date" name="tgl_sampai" class="form-control" required value="<?= $_GET['tgl_sampai'] ?? date('Y-m-d') ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Client</label>
                        <select id="client_id" name="client_id" class="form-control">
                            <option value="">Semua Client</option>
                            <?php foreach ($lihat->clietList() as $client): ?>
                                <option value="<?= $client['recid'] ?>" <?= (($_GET['client_id'] ?? '') == $client['recid']) ? 'selected' : '' ?>>
                                    <?= $client['nama_client'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </form>
            <a id="print" href="laporan_penjualan.php?page=laporan" target="_blank">🖨 Lihat & Print Laporan</a>

        </div>
    </div>
</div>

<?php
$jenis = $_GET['jenis'] ?? null;
$tgl_dari = $_GET['tgl_dari'] ?? null;
$tgl_sampai = $_GET['tgl_sampai'] ?? null;
$client_id = $_GET['client_id'] ?? null;

$data = [];
if ($jenis && $tgl_dari && $tgl_sampai) {
    if ($jenis == 'penjualan product') {
        $data = $lihat->laporan_penjualan($tgl_dari, $tgl_sampai, $client_id);
    } elseif ($jenis == 'pembelian') {
        $data = $lihat->laporan_pembelian_bahan_baku($tgl_dari, $tgl_sampai);
    } elseif ($jenis == 'produksi') {
        $data = $lihat->laporan_produksi($tgl_dari, $tgl_sampai, $client_id);
    } elseif ($jenis == 'piutang') {
        $data = $lihat->laporan_piutang($tgl_dari, $tgl_sampai, $client_id);
    }
}

?>

<?php if (!empty($data)): ?>
    <div class="card mt-3">
        <div class="card-header bg-primary text-white ">
            <strong>Hasil Laporan: <?= strtoupper($jenis) ?></strong>
        </div>
        <div class="mt-3 ml-4">
            <button id="printExcelPenjualan" class="btn btn-success">Export Excel</button>
            <button id="printExcelPDF" class="btn btn-danger" target="_blank">Export PDF</button>

        </div>
        <div class="card-body table-responsive">

            <?php if ($jenis == 'penjualan product'): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Invoice</th>
                            <th>Client</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status Bayar</th>
                            <th>Tanggal Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotal = 0;
                        foreach ($data as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <?php
                                $jatuhTempo = strtotime($row['tgl_jatuh_tempo']);
                                $hariIni = strtotime(date('Y-m-d'));
                                $isJatuhTempo = $jatuhTempo == $hariIni || $jatuhTempo < $hariIni;
                                $tdStyle = $row['status_pembayaran'] == 0 ? ($isJatuhTempo ? 'style="background-color:red; color:white;"' : '') : '';

                                echo "<td>{$row['no_invoice']}</td>
                          <td>{$row['nama_client']}</td>
                          <td>" . date('d-m-Y', strtotime($row['tgl'])) . "</td>
                          <td>Rp " . number_format($row['total_harga']) . "</td>
                          <td>{$row['status_bayar']}</td>
                          <td $tdStyle>{$row['jatuh_tempo']}</td>";

                                $subtotal += $row['total_harga'];
                                ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr class='bg-success bg-gradient text-white'>
                            <td colspan='4' class='text-end'><strong>Sub Total</strong></td>
                            <td><strong>Rp <?= number_format($subtotal) ?></strong></td>
                            <td colspan='2'></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- TABEL VERSI 2 DI SINI (untuk selain penjualan product) -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No.PO</th>
                            <!-- <th>No.INVOICE</th> -->
                            <th>Nama Supplier</th>
                            <th>Nama Bahan Baku</th>
                            <th>Qty</th>
                            <th>UOM</th>
                            <th>Status</th>
                            <th>Status Pembayaran</th>
                            <th>Jumlah Pembayaran</th>
                            <!-- <th>Harga</th> -->
                            <th>Qty Aktual</th>
                            <!-- <th>Catatan Terima</th> -->
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $subtotal = 0;
                        foreach ($data as $row): ?>
                            <?php
                            $tdStyle = $row['status_pembayaran'] != "Lunas" ? 'style="background-color:red; color:white;"' : '';

                            echo "<tr $tdStyle>";
                            ?>
                            <td><?= $no++ ?></td>
                            <?php
                            echo "<td>" . date('d-m-Y', strtotime($row['tgl'])) . "</td>
                                <td>{$row['no_po']}</td>
                          <td>{$row['nama_supplier']}</td>
                          <td>{$row['nama_bb']}</td>
                          <td>{$row['qty']}</td>
                          <td>{$row['kode_uom']}</td>
                          <td>{$row['status']}</td>
                          <td>{$row['status_pembayaran']}</td>
                          <td>Rp " . number_format($row['jumlah_bayar']) . "</td>
                          <td>{$row['qty_terima']}</td>";

                            $subtotal += $row['total_harga'];
                            ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr class='bg-success bg-gradient text-white'>
                            <td colspan='9' class='text-end'><strong>Sub Total</strong></td>
                            <td><strong>Rp <?= number_format($subtotal) ?></strong></td>
                            <td colspan='2'></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Toggle collapsible card saat judul diklik
        $('#cardHeaderFilter').on('click', function() {
            $('#filterCard').collapse('toggle');
        });


        // Auto-collapse setelah tombol submit diklik
        $('#filterForm').on('submit', function() {
            setTimeout(function() {
                $('#filterCard').collapse('hide');
            }, 100); // beri jeda agar form tetap terkirim dulu
        });

        //Print Excel
        $('#print').on('click', function() {

            let from = $('#from').val();
            let to = $('#to').val();
            let client_id = $('#client_id').val();
            let namaFile
            var x = $("#jenisLaporan").val()
            if (x == "penjualan product") {
                namaFile = "laporan_penjualan.php"
            } else {
                namaFile = "laporan_pembelian_bahanbaku.php"
            }
            console.log(x)
            // URL encode (safe)
            let query = `?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}&client_id=${encodeURIComponent(client_id)}`;
            // console.log(query)
            alert("Report Telah Di buat!");
            $("#print").attr('href', namaFile + query)


        });
    });
</script>