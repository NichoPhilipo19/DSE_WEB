<?php
// contoh ambil data dari database
$transaksi = $lihat->transaksi_bahanbaku_list();
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
                    <th>Nama Bahan Baku</th>
                    <th>Jenis</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $row): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                        <td><?= $row['nama_bb'] ?></td>
                        <td>
                            <span class="badge badge-<?= $row['jenis'] == 'masuk' ? 'success' : 'danger' ?>">
                                <?= ucfirst($row['jenis']) ?>
                            </span>
                        </td>
                        <td><?= $row['qty'] ?></td>
                        <td><?= $row['nama_uom'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td>
                            <button
                                class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $row['recid']; ?>"
                                data-aktif="<?= $row['last_number']; ?>"
                                >Edit</button>
                            <button
                                class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $row['recid']; ?>"
                                data-aktif="<?= $row['last_number']; ?>"
                                >Add Invoice</button>
                            <button
                                class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $row['recid']; ?>"
                                data-aktif="<?= $row['last_number']; ?>">Bukti Bayar</button>
                            <a href="fungsi/hapus/hapus.php?number_sequence=hapus&id=<?= $row['recid']; ?>"
                                onclick="return confirm('Hapus Data ?');">
                                <button class="btn btn-danger btn-xs">Hapus</button>
                                <button
                                class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $row['recid']; ?>"
                                data-aktif="<?= $row['last_number']; ?>">Sudah Di Terima</button>
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
            <form id="form-inventaris" action="fungsi/tambah/tambah.php?inventaris=tambah" method="POST">
                <div class="modal-body">
                    <input type="text" name="recid" id="recid_bahan_baku">
                    <input type="hidden" id="db-jml" value="0">

                    <table class="table table-striped bordered">
                        <tr>
                            <td>Nama Barang</td>
                            <td><input type="text" required class="form-control" name="nama" id="input-nama"></td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td><input type="text" required class="form-control" name="desc" id="input-desc"></td>
                        </tr>
                        <tr id="row-opsi" style="display:none;">
                            <td colspan="2">
                                <label><input type="checkbox" id="check-edit-aktif-rusak" name="check-edit-aktif-rusak"> Edit jumlah aktif & rusak</label><br>
                                <label><input type="checkbox" id="check-edit-total" name="check-edit-total"> Edit jumlah total langsung</label>

                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Total</td>
                            <td><input type="number" required class="form-control" name="jml" id="input-jml"></td>
                            <input type="hidden" name="jml" id="hidden-jml">

                        </tr>
                        <tr id="row-rusak" style="display:none;">
                            <td>Jumlah Rusak</td>
                            <td><input type="number" class="form-control" name="jml_rusak" id="input-rusak"></td>
                        </tr>
                        <tr id="row-aktif" style="display:none;">
                            <td>Jumlah Aktif</td>
                            <td><input type="number" class="form-control" name="jml_aktif" id="input-aktif"></td>
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
    });
</script>