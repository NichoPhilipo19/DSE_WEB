<?php
$clientList = $lihat->clietList();
$supplierList = $lihat->supplierList();
$selectedId = $_GET['client_id'] ?? '';
$selectedType = $_GET['type'] ?? '';
?>

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
                            <option value="stock bahan baku" <?= ($_GET['jenis'] ?? '') === 'stock bahan baku' ? 'selected' : '' ?>>Stock Bahan Baku</option>
                            <option value="uang jalan" <?= ($_GET['jenis'] ?? '') === 'uang jalan' ? 'selected' : '' ?>>Uang Jalan Supir</option>
                            <option value="pemasukan pengeluaran" <?= ($_GET['jenis'] ?? '') === 'pemasukan pengeluaran' ? 'selected' : '' ?>>Pemasukan & Pengeluaran</option>
                            <option value="piutang" <?= ($_GET['jenis'] ?? '') === 'piutang' ? 'selected' : '' ?>>Piutang</option>
                            <option value="ppn" <?= ($_GET['jenis'] ?? '') === 'ppn' ? 'selected' : '' ?>>PPn</option>
                            <option value="profit" <?= ($_GET['jenis'] ?? '') === 'profit' ? 'selected' : '' ?>>Profit</option>
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
                        <label>Supplier / Client</label>
                        <select id="client_id" name="client_id" class="form-control">
                            <option value="">Semua Client / Supplier</option>

                            <!-- Supplier -->
                            <?php foreach ($lihat->supplierList() as $supplier): ?>
                                <option
                                    value="<?= $supplier['recid'] ?>"
                                    data-type="supplier"
                                    data-nama="<?= $supplier['nama_supplier'] ?>"
                                    <?= ($selectedId == $supplier['recid']) ? 'selected' : '' ?>
                                    style="display:none;">[Supplier] <?= $supplier['nama_supplier'] ?></option>
                            <?php endforeach; ?>

                            <!-- Client -->
                            <?php foreach ($lihat->clietList() as $client): ?>
                                <option
                                    value="<?= $client['recid'] ?>"
                                    data-type="client"
                                    data-nama="<?= $client['nama_client'] ?>"
                                    <?= ($selectedId == $client['recid']) ? 'selected' : '' ?>
                                    style="display:none;">[Client] <?= $client['nama_client'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="hidden" name="type" id="selectedType" value="">
                        <input type="hidden" name="nama_client" id="nama_client" value="">
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
$selectedType = $_GET['type'] ?? null;
$nameClient = $_GET['nama_client'] ?? null;

$data = [];
if ($jenis && $tgl_dari && $tgl_sampai) {
    if ($jenis == 'penjualan product') {
        $data = $lihat->laporan_penjualan($tgl_dari, $tgl_sampai, $client_id);
    } elseif ($jenis == 'pembelian') {
        $data = $lihat->laporan_pembelian_bahan_baku($tgl_dari, $tgl_sampai);
    } elseif ($jenis == 'uang jalan') {
        $data = $lihat->laporan_uang_jalan_supir($tgl_dari, $tgl_sampai);
    } elseif ($jenis == 'pemasukan pengeluaran') {
        $data = $lihat->laporan_pemasukan_pengeluaran($tgl_dari, $tgl_sampai);
    } elseif ($jenis == 'piutang') {
        $data = $lihat->laporan_piutang($tgl_dari, $tgl_sampai);
    } elseif ($jenis == 'ppn') {
        $data = $lihat->laporan_ppn($tgl_dari, $tgl_sampai);
    } elseif ($jenis == 'profit') {
        $data = $lihat->laporan_profit($tgl_dari, $tgl_sampai);
    }
} else {
    if ($jenis == 'stock bahan baku') {
        $data = $lihat->laporan_stok_bahan_baku();
    }
}
// var_dump($data);
?>

<?php if (!empty($data)): ?>
    <div class="card mt-3">
        <div class="card-header bg-primary text-white ">
            <strong>Hasil Laporan: <?= strtoupper($jenis) ?></strong>
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
            <?php elseif ($jenis == 'pembelian'): ?>
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

                            $subtotal += $row['jumlah_bayar'];
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


            <?php elseif ($jenis == 'stock bahan baku'): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bahan Baku</th>
                            <th>Stok Tersedia</th>
                            <th>Satuan (UOM)</th>
                            <th>Minimal Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $data = $lihat->laporan_stok_bahan_baku();
                        $no = 1;
                        foreach ($data as $row): ?>
                            <tr <?= $row['stok'] < $row['batas_aman'] ? 'style="background-color: #f8d7da;"' : '' ?>>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_bb'] ?></td>
                                <td><?= $row['stok'] ?></td>
                                <td><?= $row['kode_uom'] ?></td>
                                <td><?= $row['batas_aman'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($jenis == 'uang jalan'): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Invoice</th>
                            <th>Tanggal</th>
                            <th>Client</th>
                            <th>Pengiriman</th>
                            <th>Biaya Ongkir</th>
                            <th>Ditanggung Oleh</th>
                            <th>Total Harga</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $data = $lihat->laporan_uang_jalan_supir($tgl_dari, $tgl_sampai);
                        $total_ongkir_client_count = 0;
                        $total_ongkir_subsidi_count = 0;
                        $total_ongkir_client = 0;
                        $total_ongkir_subsidi = 0;
                        foreach ($data as $row):
                            $status = $row['status_pembayaran'] == 1 ? 'Lunas' : 'Belum Lunas';
                            $penanggung = $row['penanggung_ongkir'] == 1 ? 'Perusahaan (Subsidi)' : 'Client';

                            // hitung total berdasarkan penanggung ongkir
                            if ($row['penanggung_ongkir'] == 1) {
                                $total_ongkir_subsidi += $row['ongkir'];
                                $total_ongkir_subsidi_count += 1;
                            } else {
                                $total_ongkir_client += $row['ongkir'];
                                $total_ongkir_client_count +=  1;
                            }
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['no_invoice'] ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                                <td><?= $row['nama_client'] ?></td>
                                <td><?= $row['pengiriman'] ?></td>
                                <td>Rp <?= number_format($row['ongkir']) ?></td>
                                <td><?= $penanggung ?></td>
                                <td>Rp <?= number_format($row['total_harga']) ?></td>
                                <td><?= $status ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="font-weight:bold; background:#f0f0f0;">
                            <td colspan="5" align="right">Subtotal Ongkir (Dibayar Client) (<? echo $total_ongkir_client_count ?>)</td>
                            <td colspan="4">Rp <?= number_format($total_ongkir_client) ?></td>
                        </tr>
                        <tr style="font-weight:bold; background:#f0f0f0;">
                            <td colspan="5" align="right">Subtotal Ongkir (Subsidi Perusahaan) (<? echo $total_ongkir_subsidi_count ?>)</td>
                            <td colspan="4">Rp <?= number_format($total_ongkir_subsidi) ?></td>
                        </tr>
                        <tr style="font-weight:bold; background:#d0ffd0;">
                            <td colspan="5" align="right">Grand Total Ongkir (Semua)</td>
                            <td colspan="4">Rp <?= number_format($total_ongkir_client + $total_ongkir_subsidi) ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php elseif ($jenis == 'pemasukan pengeluaran'): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                            <th>Kredit (Masuk)</th>
                            <th>Debit (Keluar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $from = $_GET['from'] ?? date('Y-m-01');
                        // $to = $_GET['to'] ?? date('Y-m-d');
                        // $data = $lihat->laporan_debit_kredit($from, $to);

                        $total_debit = 0;
                        $total_kredit = 0;

                        foreach ($data as $row):
                            $total_debit += $row['debit'];
                            $total_kredit += $row['kredit'];
                        ?>
                            <tr>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td><?= $row['nomor'] ?></td>
                                <td><?= $row['tipe'] ?></td>
                                <td><?= $row['keterangan_fix'] ?></td>
                                <td>Rp <?= number_format($row['kredit']) ?></td>
                                <td>Rp <?= number_format($row['debit']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="4" align="right">Total</td>
                            <td>Rp <?= number_format($total_kredit) ?></td>
                            <td>Rp <?= number_format($total_debit) ?></td>
                        </tr>
                        <tr style="font-weight:bold; background:#e0ffe0;">
                            <td colspan="4" align="right">Saldo Akhir (Kredit - Debit)</td>
                            <td colspan="2">Rp <?= number_format($total_kredit - $total_debit) ?></td>
                        </tr>
                    </tfoot>
                </table>

            <?php elseif ($jenis == 'piutang'): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $from = $_GET['from'] ?? date('Y-m-01');
                        // $to = $_GET['to'] ?? date('Y-m-d');
                        // $data = $lihat->laporan_debit_kredit($from, $to);

                        $total = 0;

                        foreach ($data as $row):
                            $total += $row['Jumlah'];
                        ?>
                            <tr>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td><?= $row['nomor'] ?></td>
                                <td><?= $row['tipe'] ?></td>
                                <td><?= $row['keterangan_fix'] ?></td>
                                <td>Rp <?= number_format($row['Jumlah']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold; background:#e0ffe0;">
                            <td colspan="4" align="right">Total Piutang</td>
                            <td colspan="2">Rp <?= number_format($total) ?></td>
                        </tr>
                    </tfoot>
                </table>
            <?php elseif ($jenis == 'ppn'): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Invoice</th>
                            <th>Nama Client</th>
                            <th>Total Harga</th>
                            <th>PPn (11%)</th>
                            <th>Pakai PPn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $from = $_GET['from'] ?? date('Y-m-01');
                        // $to = $_GET['to'] ?? date('Y-m-d');
                        // $data = $lihat->laporan_debit_kredit($from, $to);

                        $total = 0;

                        $no = 1;
                        foreach ($data as $row):
                            $total += $row['total_ppn'];
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                                <td><?= $row['no_invoice'] ?></td>
                                <td><?= $row['nama_client'] ?></td>
                                <td>Rp <?= number_format($row['total_harga']) ?></td>
                                <td>Rp <?= number_format($row['total_ppn']) ?></td>
                                <td><?= $row['pakai_ppn'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold; background:#e0ffe0;">
                            <td colspan="5" align="right">Total PPn</td>
                            <td colspan="2">Rp <?= number_format($total) ?></td>
                        </tr>
                    </tfoot>
                </table>
            <?php elseif ($jenis == 'profit'): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Invoice</th>
                            <th>Client</th>
                            <th>Produk</th>
                            <th>Qty (Ton)</th>
                            <th>Harga per Ton</th>
                            <th>Total Harga</th>
                            <th>Profit</th>
                            <th>Profit Bahan Baku</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $data = $lihat->laporan_profit('2025-07-01', '2025-07-31');
                        $total_profit = 0;
                        $total_profit_bb = 0;

                        foreach ($data as $no => $row) {
                            $total_profit += $row['profit'];
                            $total_profit_bb += $row['profit_bahanbaku'];
                            echo "<tr>
                <td>" . ($no + 1) . "</td>
                <td>" . date('d-m-Y', strtotime($row['tgl'])) . "</td>
                <td>{$row['no_invoice']}</td>
                <td>{$row['nama_client']}</td>
                <td>{$row['nama_produk']}</td>
                <td align='right'>" . number_format($row['qty'], 2) . "</td>
                <td align='right'>Rp " . number_format($row['hargaPerTon'], 0) . "</td>
                <td align='right'>Rp " . number_format($row['total_harga'], 0) . "</td>
                <td align='right'>Rp " . number_format($row['profit'], 0) . "</td>
                <td align='right'>Rp " . number_format($row['profit_bahanbaku'], 0) . "</td>
            </tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" align="right">TOTAL</td>
                            <td align="right">Rp <?= number_format($total_profit, 0); ?></td>
                            <td align="right">Rp <?= number_format($total_profit_bb, 0); ?></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>


        </div>
    </div>
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const selectedClientType = "<?= $selectedType ?>";
    const selectedClient = "<?= $selectedId ?>";
    const nameClient = "<?= $nameClient ?>";
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
            } else if (x == "pembelian") {
                namaFile = "laporan_pembelian_bahanbaku.php"
            } else if (x == "stock bahan baku") {
                namaFile = "laporan_bahan_baku.php"
            } else if (x == "uang jalan") {
                namaFile = "laporan_uang_jalan.php"
            } else if (x == "pemasukan pengeluaran") {
                namaFile = "laporan_pemasukan_pengeluaran.php"
            } else if (x == "piutang") {
                namaFile = "laporan_piutang.php"
            } else if (x == "ppn") {
                namaFile = "laporan_ppn.php"
            } else if (x == "profit") {
                namaFile = "laporan_profit.php"
            }
            console.log(x)
            // URL encode (safe)
            let query = `?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}&client_id=${encodeURIComponent(client_id)}`;
            // console.log(query)
            alert("Report Telah Di buat!");
            $("#print").attr('href', namaFile + query)


        });

        function toogleDisabled() {
            var jenis = $('#jenisLaporan').val();
            var isSell = jenis === 'penjualan product';
            var isBuy = jenis === 'pembelian';
            var isStock = jenis === 'stock bahan baku';
            var isUangJalan = jenis === 'uang jalan';
            var isDebitKredit = jenis === 'pemasukan pengeluaran';
            var isPiutang = jenis === 'piutang';
            var isPpn = jenis === 'ppn';
            var isProfit = jenis === 'profit';

            if (isSell) {

                $('#from').prop('disabled', false);
                $('#to').prop('disabled', false);
                $('#client_id').prop('disabled', false);

            } else if (isBuy) {

                $('#from').prop('disabled', false);
                $('#to').prop('disabled', false);
                $('#client_id').prop('disabled', false);

            } else if (isStock) {

                $('#from').prop('disabled', true);
                $('#to').prop('disabled', true);
                $('#client_id').prop('disabled', true);

            } else if (isUangJalan) {

                $('#from').prop('disabled', false);
                $('#to').prop('disabled', false);
                $('#client_id').prop('disabled', true);

            } else if (isDebitKredit) {

                $('#from').prop('disabled', false);
                $('#to').prop('disabled', false);
                $('#client_id').prop('disabled', true);

            } else if (isPiutang) {

                $('#from').prop('disabled', false);
                $('#to').prop('disabled', false);
                $('#client_id').prop('disabled', true);

            } else if (isPpn) {

                $('#from').prop('disabled', false);
                $('#to').prop('disabled', false);
                $('#client_id').prop('disabled', true);

            } else if (isProfit) {

                $('#from').prop('disabled', false);
                $('#to').prop('disabled', false);
                $('#client_id').prop('disabled', true);

            } else {

                $('#from').prop('disabled', true);
                $('#to').prop('disabled', true);
                $('#client_id').prop('disabled', true);

            }
        }

        function toggleFilters() {
            var jenis = $('#jenisLaporan').val();
            var isSell = jenis === 'penjualan product';
            var isBuy = jenis === 'pembelian';
            var isStock = jenis === 'stock bahan baku';
            var isUangJalan = jenis === 'uang jalan';
            var isDebitKredit = jenis === 'pemasukan pengeluaran';
            var isPiutang = jenis === 'piutang';
            var isPpn = jenis === 'ppn';
            var isProfit = jenis === 'profit';

            // $('#from').prop('disabled', isStock);
            // $('#to').prop('disabled', isStock);
            // $('#client_id').prop('disabled', isStock);
            if (isSell) {
                $('#from, #to').attr('required');
                $('#client_id').removeAttr('required');
            } else if (isBuy) {
                $('#from, #to').attr('required');
                $('#client_id').removeAttr('required');
            } else if (isStock) {
                $('#from, #to, #client_id').removeAttr('required');
            } else if (isUangJalan) {
                $('#from, #to').attr('required');
                $('#client_id').removeAttr('required');
            } else if (isDebitKredit) {
                $('#from, #to').attr('required');
                $('#client_id').removeAttr('required');
            } else if (isPiutang) {
                $('#from, #to').attr('required');
                $('#client_id').removeAttr('required');
            } else if (isPpn) {
                $('#from, #to').attr('required');
                $('#client_id').removeAttr('required');
            } else if (isProfit) {
                $('#from, #to').attr('required');
                $('#client_id').removeAttr('required');
            } else {
                $('#from, #to, #client_id').removeAttr('required');
            }
        }

        // Jalankan saat pertama load
        toggleFilters();
        toogleDisabled();
        filterClientSupplier($('#jenisLaporan').val());
        filterOptionsByJenis($('#jenisLaporan').val());

        // Jalankan saat jenis laporan diubah
        $('#jenisLaporan').on('change', function() {
            toggleFilters();
            toogleDisabled();
            filterClientSupplier($(this).val());
            filterOptionsByJenis($(this).val());
        });

        function filterOptionsByJenis(jenis) {
            // 1. Tentukan tipe yang ditampilkan
            if (jenis === 'pembelian') {
                $('#client_id option[data-type="supplier"]').show();
            } else if (jenis === 'pemasukan pengeluaran') {
                $('#client_id option[data-type="supplier"]').show();
                $('#client_id option[data-type="client"]').show();
            } else {
                $('#client_id option[data-type="client"]').show();
            }

            // 3. Cek apakah selected option cocok dengan tipe yang ditampilkan
            let showType = $("#selectedType").val();
            let selectedOption = $('#client_id option:selected');
            if (selectedOption.length && selectedOption.data('type') !== selectedClientType) {

                $('#client_id').val(""); // reset dulu
                $('#client_id option').filter(function() {
                    return $(this).val() == '1' && $(this).data('type') == selectedClientType;
                }).prop('selected', true);
            }
        }
        $("#selectedType").val(selectedClientType)
        $("#nama_client").val(nameClient)
        $('#client_id').on("change", function() {
            let selectedOption = $('#client_id option:selected');
            let set = $("#selectedType").val(selectedOption.data('type'));
            let set2 = $("#nama_client").val(selectedOption.data('nama'));
            console.log(selectedOption);
        })

        function filterClientSupplier(jenis) {
            $('#client_id option[data-type]').hide(); // sembunyikan semua opsi bertipe
            if (jenis === 'pembelian') {
                $('#client_id option[data-type="supplier"]').show();
            } else if (jenis === 'pemasukan pengeluaran') {
                $('#client_id option[data-type="supplier"]').show();
                $('#client_id option[data-type="client"]').show();
            } else {
                $('#client_id option[data-type="client"]').show();
            }
        }
    });
</script>