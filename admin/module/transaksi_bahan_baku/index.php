<?php
// contoh ambil data dari database
$transaksi = $lihat->transaksi_bahanbaku_list();
$bahanbaku = $lihat->bahanbaku();
?>
<h4 class="mb-4">Transaksi Bahan Baku</h4>
<?php if (isset($_GET['success']) && $_GET['success'] == "tambah") { ?>
    <div class="alert alert-success">
        <p>Tambah Draft Berhasil !</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'order') { ?>
    <div class="alert alert-success">
        <p>Status berhasil diubah menjadi In Order !</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'invoice') { ?>
    <div class="alert alert-success">
        <p>Invoice telah di tambahkan</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'bukti') { ?>
    <div class="alert alert-success">
        <p>Pembayaran telah di update</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'terima') { ?>
    <div class="alert alert-success">
        <p>Status berhasil diubah menjadi Finish !</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'hapus') { ?>
    <div class="alert alert-success">
        <p>Data berhasil di hapus !</p>
    </div>
<?php } ?>

<!-- Tombol tambah -->
<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
    <i class="fas fa-plus"></i> Buat PO Bahan Baku
</button>

<!-- Tabel -->
<div class="card shadow">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>No.PO</th>
                    <th>No.INVOICE</th>
                    <th>Nama Bahan Baku</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <!-- <th>Harga</th> -->
                    <th>Status</th>
                    <th><small>Bukti<br>Pembayaran</small></th>
                    <th>Jumlah Pembayaran</th>
                    <th>Qty Aktual</th>
                    <th>Catatan Terima</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $row): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
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
                        <!-- <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td> -->
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
                                <a href="http://localhost/DSE_WEB/assets/bukti_bayar_po/<?= $row['bukti_file'] ?>" target="_blank">
                                    <!-- <a href="../../assets/bukti_bayar_po/<?= $row['bukti_file'] ?>" target="_blank"> -->
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
                        </td>
                        <td>
                            <?php if ($row['status'] == 0) { ?>
                                <button
                                    class="btn btn-warning btn-xs btn-edit"
                                    data-toggle="modal"
                                    data-target="#modalTambah"
                                    data-recid="<?= $row['recid']; ?>"
                                    data-bahanbaku="<?= $row['bahanbaku_id']; ?>"
                                    data-qty="<?= $row['qty']; ?>"
                                    data-uom="<?= $row['uom']; ?>"
                                    data-supp="<?= $row['supp_id']; ?>">Edit</button>

                                <a href="fungsi/hapus/hapus.php?transaksi_bahan_baku=hapus&id=<?= $row['recid']; ?>"
                                    onclick="return confirm('Hapus Data ?');">
                                    <button class="btn btn-danger btn-xs">Hapus</button>
                                </a>

                                <button
                                    class="btn btn-success btn-xs btn-order"
                                    data-toggle="modal"
                                    data-target="#modalOrder"
                                    data-recid="<?= $row['recid']; ?>">Order</button>
                            <?php } ?>
                            <?php if ($row['status'] == 1) { ?>
                                <!-- <button
                                    class="btn btn-warning btn-xs btn-edit"
                                    data-toggle="modal"
                                    data-target="#modalTambah"
                                    data-recid="<?= $row['recid']; ?>">Edit</button> -->


                                <?php if (!empty($row['no_invoice']) && empty($row['bukti_file'])) { ?>
                                    <button
                                        class="btn btn-info btn-xs btn-bukti-bayar"
                                        data-id="<?= $row['recid']; ?>">
                                        Bukti Bayar
                                    </button>

                                <?php } ?>

                                <?php if (!empty($row['bukti_file'])) { ?>
                                    <button
                                        class="btn btn-success btn-xs btn-terima"
                                        data-toggle="modal"
                                        data-target="#modalTerima"
                                        data-id="<?= $row['recid']; ?>"
                                        data-qty="<?= $row['qty']; ?>"
                                        data-bahanbakuid="<?= $row['bahanbaku_id']; ?>">
                                        Sudah Diterima
                                    </button>
                                <?php } ?>

                            <?php } ?>


                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div id="modalTambah" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header" style="background:#285c64;color:#fff;">
                <h5 class="modal-title" id="modal-title"><i class="fa fa-plus"></i> Form PO Bahan Baku</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form-transaksi" action="fungsi/tambah/tambah.php?transaksi_bahan_baku=tambah" method="POST">
                <input type="hidden" name="edit_revid" id="edit-recid">
                <div class="modal-body">
                    <table class="table table-striped bordered" id="draft-table-form">
                        <tr>
                            <td>Bahan Baku</td>
                            <td>
                                <select class="form-control" id="select-bahanbaku">
                                    <option value="">-- Pilih Bahan Baku --</option>
                                    <?php foreach ($bahanbaku as $bb): ?>
                                        <option value="<?= $bb['recid'] ?>" data-uom="<?= $bb['satuan'] ?>" data-supp="<?= $bb['supp_id'] ?>">
                                            <?= $bb['nama_bb'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <input type="hidden" name="bahanbaku_id" id="bahanbaku_id">
                                <input type="hidden" name="supp_id" id="supp_id">
                            </td>
                        </tr>
                        <tr>
                            <td>Qty</td>
                            <td><input type="number" class="form-control" name="qty" id="input-qty"></td>
                        </tr>
                        <tr>
                            <td>UOM</td>
                            <td><input type="text" readonly class="form-control" name="uom" id="input-uom"></td>
                        </tr>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-submit"><i class="fa fa-plus"></i> Insert Data</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalOrder" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <form id="form-order" action="fungsi/edit/edit.php?order_transaksi_bahanbaku=1" method="POST">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Konfirmasi Order</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin mengubah status menjadi <strong>In Order</strong>?</p>
                    <input type="hidden" name="recid_order" id="recid-order">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya, Order</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="modalAddInvoice" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="fungsi/edit/edit.php?transaksi_bahanbaku=add_invoice" method="POST">
            <div class="modal-content" style="border-radius:0px;">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fa fa-file-invoice"></i> Tambah Invoice</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="recid" id="invoice-recid">
                    <div class="form-group">
                        <label>No. PO</label>
                        <input type="text" class="form-control" id="invoice-no-po" readonly>
                    </div>
                    <div class="form-group">
                        <label>No. Invoice</label>
                        <input type="text" name="no_invoice" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Total)</label>
                        <input type="text" class="form-control" id="input-harga-format" required>
                        <input type="hidden" name="harga" id="input-harga"> <!-- ini yang dikirim ke PHP -->


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Invoice</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Bukti Pembayaran -->
<div class="modal fade" id="modalBuktiBayar" tabindex="-1" role="dialog" aria-labelledby="modalBuktiBayarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="fungsi/edit/edit.php?bukti_bayar_po=submit" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="recid" id="bukti-recid">

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
        <form action="fungsi/edit/edit.php?transaksi_bahanbaku=terima_barang" method="POST">
            <div class="modal-content" style="border-radius:0px;">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fa fa-file-invoice"></i> Konfirmasi Penerimaan Barang</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="terima-recid">
                    <div class="form-group">
                        <label for="qty_aktual">Qty Diterima</label>
                        <input type="number" name="qty_aktual" class="form-control" step="0.01" required>
                        <input type="hidden" name="qty" id="qty_po">
                        <input type="hidden" name="bahanbakuid" id="bahanbakuid">
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan Penerimaan</label>
                        <textarea name="catatan" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
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
        if (urlParams.get('openModal') === 'tambah') {
            $('#modalTambah').modal('show');
            $('#recid_bahan_baku').val(urlParams.get('recid'))
        }

        $('#input-harga-format').on('input', function() {
            let raw = $(this).val().replace(/[^0-9]/g, ''); // Ambil angka mentah
            $('#input-harga').val(raw); // Simpan ke hidden input
            $(this).val(formatRupiah(raw)); // Tampilkan format Rupiah
        });

        $('#modalTambah').on('hidden.bs.modal', function() {
            $('#form-transaksi')[0].reset();
            $('#form-transaksi').attr('action', 'fungsi/tambah/tambah.php?transaksi_bahan_baku=tambah');
            $('#modal-title').text('Form PO Bahan Baku');
            $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
            $('#edit-recid').val('');
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
            const no_po = $(this).data('no_po');

            $('#invoice-recid').val(recid);
            $('#invoice-no-po').val(no_po);
        });

        $('.format-nominal').on('input', function() {
            let value = $(this).val().replace(/[^,\d]/g, '');


            $(this).val(formatRupiah(value));
        });


        // Saat tombol Bukti Bayar diklik, isi hidden input recid
        $('.btn-bukti-bayar').click(function() {
            const recid = $(this).data('id');
            $('#bukti-recid').val(recid);
            $('#modalBuktiBayar').modal('show');
        });

        $('.btn-terima').click(function() {
            const recid = $(this).data('id');
            const qty_po = $(this).data('qty');
            const bahanbakuid = $(this).data('bahanbakuid');
            $('#terima-recid').val(recid);
            $('#qty_po').val(qty_po);
            $('#bahanbakuid').val(bahanbakuid);
        });


    });
</script>