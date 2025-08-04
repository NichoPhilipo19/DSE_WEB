<?php
// contoh ambil data dari database
// $transaksi = $lihat->transaksi_penjualan_list();
$bahanbaku = $lihat->bahanbaku();
?>
<h4 class="mb-4">Transaksi Penjualan</h4>
<?php if (isset($_GET['success']) && $_GET['success'] == 'invoice') { ?>
    <div class="alert alert-success">
        <p>Nomor Purchase Order Client telah di tambahkan</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'bukti') { ?>
    <div class="alert alert-success">
        <p>Pembayaran telah di update</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'terima') { ?>
    <div class="alert alert-success">
        <p>Pesanan telah di terima Client!</p>
    </div>
<?php } ?>

<?php
// Default tanggal
$today = date('Y-m-d');
$oneMonthAgo = date('Y-m-d', strtotime('-1 month'));

// --- Ambil tanggal filter ---
$tgl_dari = $_GET['tgl_dari'] ?? $oneMonthAgo;
$tgl_sampai = $_GET['tgl_sampai'] ?? $today;

// --- Jumlah per halaman ---
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$offset = ($page - 1) * $limit;

// --- Hitung total data ---
$totalData = $lihat->hitung_transaksi_penjualan_filter($tgl_dari, $tgl_sampai);

// --- Hitung total halaman ---
$totalPages = ceil($totalData / $limit);

// --- Ambil data terbatas ---
$transaksi = $lihat->transaksi_penjualan_filter_limit($tgl_dari, $tgl_sampai, $limit, $offset);
// echo "Limit: $limit | Offset: $offset | Page: $page<br>";

?>

<form method="GET" class="mb-3">
    <input type="hidden" name="page" value="penjualan">
    <div class="form-row">
        <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" name="tgl_dari" class="form-control" value="<?= $tgl_dari ?>">
        </div>
        <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" name="tgl_sampai" class="form-control" value="<?= $tgl_sampai ?>">
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </div>
</form>

<!-- Tabel -->
<div class="card shadow">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Client</th>
                    <th>Tanggal</th>
                    <th>Qty (Ton)</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>


                    <!-- <th>Tanggal</th>
                    <th>No.PO</th>
                    <th>No.INVOICE</th>
                    <th>Nama Bahan Baku</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th><small>Bukti<br>Pembayaran</small></th>
                    <th>Jumlah Pembayaran</th>
                    <th>Qty Aktual</th>
                    <th>Catatan Terima</th>
                    <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($transaksi as $row):
                    $total = ($row['hargaPerTon'] * $row['qty']) + $row['ppn'] + ($row['penanggung_ongkir'] == 1 ? 0 : $row['ongkir']);
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['no_invoice'] ?></td>
                        <td><?= $row['nama_client'] ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                        <td><?= $row['qty'] ?></td>
                        <td>Rp <?= number_format($total) ?></td>
                        <td><?= $row['status_pembayaran'] == 1 ? 'Lunas' : 'Belum Lunas' ?></td>


                        <!-- <td><?= date('Y/m/d', strtotime($row['tgl'])) ?></td>
                        <td><?= $row['no_po'] ?></td>
                        <td>
                            <?php if (!empty($row['no_po']) && empty($row['no_invoice'])) { ?>
                                <button
                                    class="btn btn-success btn-xs btn-add-invoice"
                                    data-toggle="modal" data-target="#modalAddInvoice"
                                    data-id="<?= $row['recid']; ?>"
                                    data-no_po="<?= $row['no_po']; ?>">Add Invoice</button>
                            <?php } else { ?>
                                <?= $row['no_invoice']; ?>
                            <?php } ?>
                        </td>
                        <td><?= $row['nama_bb'] ?></td>
                        <td><?= $row['qty'] ?></td>
                        <td><?= $row['uom'] ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($row['status'] == 0) { ?>
                                Draft
                            <?php } else if ($row['status'] == 1) { ?>
                                In Order
                            <?php } else if ($row['status'] == 2) { ?>
                                Finish
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($row['bukti_file'])): ?>
                                <a href="assets/bukti_bayar/<?= $row['bukti_file'] ?>" target="_blank">
                                    Lihat File
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                        </td>
                        <td>
                            <?= $row['qty_terima']; ?>
                        </td>
                        <td>
                            <?= $row['catatan_terima']; ?>
                        </td> -->


                        <td>
                            <a href="index.php?page=penjualan/details&no_invoice=<?php echo $row['no_invoice']; ?>" target="_blank">
                                <button class="btn btn-primary btn-xs">Detail</button>
                            </a>

                            <?php if (empty($row['no_po'])) { ?>
                                <button
                                    class="btn btn-success btn-xs btn-add-invoice"
                                    data-toggle="modal" data-target="#modalAddInvoice"
                                    data-id="<?= $row['recid']; ?>">Add No.PO Client</button>
                            <?php } ?>
                            <?php if (!empty($row['no_po']) && empty($row['buktibayar'])) { ?>
                                <button
                                    class="btn btn-info btn-xs btn-bukti-bayar"
                                    data-id="<?= $row['recid']; ?>"
                                    data-nama="<?= $row['nama_client']; ?>">
                                    Bukti Bayar
                                </button>

                            <?php } ?>

                            <?php if (!empty($row['buktibayar']) && $row['sudah_diterima'] == 0) { ?>
                                <button
                                    class="btn btn-success btn-xs btn-terima"
                                    data-toggle="modal"
                                    data-target="#modalTerima"
                                    data-id="<?= $row['recid']; ?>">
                                    Sudah Diterima
                                </button>
                            <?php } ?>
                            <!-- <a id="print" href="laporan_penjualan.php?page=laporan" target="_blank">🖨 Lihat & Print Laporan</a> -->
                            <a id="print" href="invoice.php?page=invoice&inv=<?= $row['no_invoice']; ?>" target="_blank">
                                <button
                                    class="btn btn-secondary">
                                    🖨 Print Invoice
                                </button>
                            </a>

                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <!-- Pilihan jumlah data per halaman -->
        <form method="GET" class="form-inline mt-3">
            <input type="hidden" name="page" value="penjualan">
            <input type="hidden" name="tgl_dari" value="<?= $tgl_dari ?>">
            <input type="hidden" name="tgl_sampai" value="<?= $tgl_sampai ?>">
            <label>Data per halaman: </label>
            <select name="limit" class="form-control mx-2" onchange="this.form.submit()">
                <option <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                <option <?= $limit == 25 ? 'selected' : '' ?>>25</option>
                <option <?= $limit == 50 ? 'selected' : '' ?>>50</option>
            </select>
        </form>

        <!-- Navigasi halaman -->
        <nav class="mt-2">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link"
                            href="?page=penjualan&tgl_dari=<?= $tgl_dari ?>&tgl_sampai=<?= $tgl_sampai ?>&limit=<?= $limit ?>&page_num=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>
</div>

<!-- Modal -->
<div id="modalAddInvoice" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="fungsi/edit/edit.php?transaksi_penjualan=add_po" method="POST">
            <div class="modal-content" style="border-radius:0px;">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fa fa-file-invoice"></i> Tambah PO Client</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="recid" id="invoice-recid">
                    <div class="form-group">
                        <label>No. PO</label>
                        <input type="text" class="form-control" name="no_invoice" id="invoice-no-po">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan NO.PO</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Bukti Pembayaran -->
<div class="modal fade" id="modalBuktiBayar" tabindex="-1" role="dialog" aria-labelledby="modalBuktiBayarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="fungsi/edit/edit.php?bukti_bayar_inv=submit" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="recid" id="bukti-recid">
                    <input type="hidden" name="namaclient" id="nama-client">

                    <div class="form-group">
                        <label for="tgl_bayar">Tanggal Pembayaran</label>
                        <input type="date" id="tglbyr" name="tgl_bayar" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_bayar">Jumlah Pembayaran</label>
                        <input type="text" name="jumlah_bayar" id="jumlah_bayar" class="form-control format-nominal" required>
                    </div>

                    <div class="form-group">
                        <label for="bukti_file">Upload Bukti</label>
                        <input type="file" name="bukti_file" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.innerText='Submitting...'; this.form.submit();">Submit</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="modalTerima" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="fungsi/edit/edit.php?transaksi_keluar=terima" method="POST">
            <div class="modal-content" style="border-radius:0px;">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fa fa-file-invoice"></i> Konfirmasi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin pesanan telah sampai di tempat client?
                    <input type="hidden" name="id" id="terima-recid">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);


        $('#input-harga-format').on('input', function() {
            let raw = $(this).val().replace(/[^0-9]/g, ''); // Ambil angka mentah
            $('#input-harga').val(raw); // Simpan ke hidden input
            $(this).val(formatRupiah(raw)); // Tampilkan format Rupiah
        });

        $('#select-bahanbaku').change(function() {
            const uom = $('#select-bahanbaku option:selected').data('uom');
            const supp_id = $('#select-bahanbaku option:selected').data('supp');
            const val = $('#select-bahanbaku option:selected').val();
            $('#input-uom').val(uom || '');
            $('#bahanbaku_id').val(val || '');
            $('#supp_id').val(supp_id || '');
        });

        $('.btn-edit').click(function() {
            $('#form-transaksi').attr('action', 'fungsi/edit/edit.php?transaksi_bahanbaku=edit');

            const recid = $(this).data('recid');
            const bahanbaku = $(this).data('bahanbaku');
            const qty = $(this).data('qty');
            const uom = $(this).data('uom');
            const supp_id = $(this).data('supp');

            // Isi nilai ke form
            $('#modal-title').text('Edit Draft PO Bahan Baku');
            $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

            $('#edit-recid').val(recid);
            $('#bahanbaku_id').val(bahanbaku);
            $('#input-qty').val(qty);
            $('#input-uom').val(uom);
            $('#supp_id').val(supp_id);

            // Set selected option bahan baku (optional)
            $('#select-bahanbaku').val(bahanbaku);

        });

        $('.btn-order').click(function() {
            const recid = $(this).data('recid');
            $('#recid-order').val(recid);
        });

        $('.btn-add-invoice').on('click', function() {
            const recid = $(this).data('id');

            $('#invoice-recid').val(recid);
        });

        $('.format-nominal').on('input', function() {
            let value = $(this).val().replace(/[^,\d]/g, '');


            $(this).val(formatRupiah(value));
        });


        // Saat tombol Bukti Bayar diklik, isi hidden input recid
        $('.btn-bukti-bayar').click(function() {
            const recid = $(this).data('id');
            const nama_client = $(this).data('nama');
            $('#bukti-recid').val(recid);
            $('#nama-client').val(nama_client);
            $('#modalBuktiBayar').modal('show');
        });

        $('.btn-terima').click(function() {
            const recid = $(this).data('id');
            $('#terima-recid').val(recid);
        });


    });
</script>