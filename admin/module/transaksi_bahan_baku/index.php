<?php
// contoh ambil data dari database
$transaksi = $lihat->transaksi_bahanbaku_list();
$bahanbaku = $lihat->bahanbaku();
?>
<h4 class="mb-4">Transaksi Bahan Baku</h4>
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">
        <p>Tambah Inventaris Berhasil !</p>
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
                    <th>Nama Bahan Baku</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $row): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                        <td><?= $row['no_po'] ?></td>
                        <td><?= $row['nama_bb'] ?></td>
                        <td><?= $row['qty'] ?></td>
                        <td><?= $row['uom'] ?></td>
                        <td>
                            <?php if ($row['status'] == 0) { ?>
                                Draft
                            <?php } else if ($row['status'] == 1) { ?>
                                In Order
                            <?php } else if ($row['status'] == 3) { ?>
                                Bahan Baku Diterima
                            <?php } ?>
                        </td>
                        <td><?= $row['keterangan'] ?></td>
                        <td>
                            <?php if ($row['status'] == 0) { ?>
                                <button
                                    class="btn btn-warning btn-xs btn-edit"
                                    data-toggle="modal" data-target="#modalTambah"
                                    data-id="<?= $row['recid']; ?>"
                                    data-aktif="<?= $row['last_number']; ?>">Edit</button>
                                <button
                                    class="btn btn-warning btn-xs btn-edit"
                                    data-toggle="modal" data-target="#myModal"
                                    data-id="<?= $row['recid']; ?>"
                                    data-aktif="<?= $row['last_number']; ?>">Order</button>
                                <a href="fungsi/hapus/hapus.php?number_sequence=hapus&id=<?= $row['recid']; ?>"
                                    onclick="return confirm('Hapus Data ?');">
                                    <button class="btn btn-danger btn-xs">Hapus</button>
                                <?php } ?>
                                <?php if ($row['status'] == 1) { ?>
                                    <button
                                        class="btn btn-warning btn-xs btn-edit"
                                        data-toggle="modal" data-target="#myModal"
                                        data-id="<?= $row['recid']; ?>"
                                        data-aktif="<?= $row['last_number']; ?>">Add Invoice</button>
                                    <button
                                        class="btn btn-warning btn-xs btn-edit"
                                        data-toggle="modal" data-target="#myModal"
                                        data-id="<?= $row['recid']; ?>"
                                        data-aktif="<?= $row['last_number']; ?>">Bukti Bayar</button>
                                    <button
                                        class="btn btn-warning btn-xs btn-edit"
                                        data-toggle="modal" data-target="#myModal"
                                        data-id="<?= $row['recid']; ?>"
                                        data-aktif="<?= $row['last_number']; ?>">Sudah Di Terima</button>
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
            <form action="fungsi/tambah/tambah.php?transaksi_bahan_baku=tambah" method="POST">
                <div class="modal-body">
                    <table class="table table-striped bordered" id="draft-table-form">
                        <tr>
                            <td>Bahan Baku</td>
                            <td>
                                <select class="form-control" id="select-bahanbaku">
                                    <option value="">-- Pilih Bahan Baku --</option>
                                    <?php foreach ($bahanbaku as $bb): ?>
                                        <option value="<?= $bb['recid'] ?>" data-uom="<?= $bb['satuan'] ?>">
                                            <?= $bb['nama_bb'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <input type="hidden" name="bahanbaku_id" id="bahanbaku_id">
                            </td>
                        </tr>
                        <tr>
                            <td>Qty</td>
                            <td><input type="number" class="form-control" name="qty" id="input-qty"></td>
                        </tr>
                        <tr>
                            <td>UOM</td>
                            <td><input type="text" readonly class="form-control"name="uom" id="input-uom"></td>
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

<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('openModal') === 'tambah') {
            $('#modalTambah').modal('show');
            $('#recid_bahan_baku').val(urlParams.get('recid'))
        }

        $('#select-bahanbaku').change(function() {
            const uom = $('#select-bahanbaku option:selected').data('uom');
            const val = $('#select-bahanbaku option:selected').val();
            $('#input-uom').val(uom || '');
            $('#bahanbaku_id').val(val || '');
        });

        
    });
</script>