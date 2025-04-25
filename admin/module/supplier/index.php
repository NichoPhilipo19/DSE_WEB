<h4>Data Supplier</h4>
<br />
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success"><p>Tambah Supplier Berhasil!</p></div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger"><p>Hapus Supplier Berhasil!</p></div>
<?php } ?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> Insert Data</button>
<a href="index.php?page=supplier" class="btn btn-success"><i class="fa fa-refresh"></i> Refresh</a>
<br /><br />

<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Fax</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hasil = $lihat->supplierList(); // pastikan function ini sudah ada
                $no = 1;
                foreach ($hasil as $isi) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $isi['nama_supplier']; ?></td>
                        <td><?= $isi['alamat']; ?></td>
                        <td><?= $isi['email']; ?></td>
                        <td><?= $isi['no_telp']; ?></td>
                        <td><?= $isi['fax']; ?></td>
                        <td><?= $isi['status'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
                        <td>
                            <button class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $isi['recid']; ?>"
                                data-nama="<?= $isi['nama_supplier']; ?>"
                                data-alamat="<?= $isi['alamat']; ?>"
                                data-email="<?= $isi['email']; ?>"
                                data-notelp="<?= $isi['no_telp']; ?>"
                                data-fax="<?= $isi['fax']; ?>"
                                data-status="<?= $isi['status']; ?>">Edit</button>
                            <a href="fungsi/hapus/hapus.php?supplier=hapus&id=<?= $isi['recid']; ?>"
                                onclick="return confirm('Hapus data supplier?');">
                                <button class="btn btn-danger btn-xs">Hapus</button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modal-title"><i class="fa fa-plus"></i> Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form-supplier" action="fungsi/tambah/tambah.php?supplier=tambah" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="recid" id="input-id">
                    <table class="table table-bordered">
                        <tr><td>Nama Supplier</td><td><input type="text" name="nama_supplier" id="input-nama" class="form-control" required></td></tr>
                        <tr><td>Alamat</td><td><input type="text" name="alamat" id="input-alamat" class="form-control" required></td></tr>
                        <tr><td>Email</td><td><input type="email" name="email" id="input-email" class="form-control" required></td></tr>
                        <tr><td>No. Telp</td><td><input type="number" name="no_telp" id="input-notelp" class="form-control" required></td></tr>
                        <tr><td>Fax</td><td><input type="number" name="fax" id="input-fax" class="form-control"></td></tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <select name="status" id="input-status" class="form-control" required>
                                    <option value="">- Pilih Status -</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-submit" class="btn btn-primary"><i class="fa fa-plus"></i> Insert Data</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            $('#modal-title').html('<i class="fa fa-edit"></i> Edit Supplier');
            $('#form-supplier').attr('action', 'fungsi/edit/edit.php?supplier=edit');
            $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

            $('#input-id').val($(this).data('id'));
            $('#input-nama').val($(this).data('nama'));
            $('#input-alamat').val($(this).data('alamat'));
            $('#input-email').val($(this).data('email'));
            $('#input-notelp').val($(this).data('notelp'));
            $('#input-fax').val($(this).data('fax'));
            $('#input-status').val($(this).data('status'));
        });

        $('[data-target="#myModal"]:not(.btn-edit)').on('click', function() {
            $('#modal-title').html('<i class="fa fa-plus"></i> Tambah Supplier');
            $('#form-supplier').attr('action', 'fungsi/tambah/tambah.php?supplier=tambah');
            $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
            // $('#form-supplier')[0].reset();
        });
    });
</script>
