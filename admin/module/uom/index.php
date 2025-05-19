<h4>Data Unit of Measure</h4>
<br />
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">
        <p>Tambah Unit of Measure Berhasil!</p>
    </div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger">
        <p>Hapus Unit of Measure Berhasil!</p>
    </div>
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
                    <th>Kode UOM</th>
                    <th>Nama Unit of Measure</th>
                    <th>Batas Aman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hasil = $lihat->uomList(); // Pastikan method ini mengembalikan data dari tabel uom
                $no = 1;
                foreach ($hasil as $isi) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $isi['kode_uom']; ?></td>
                        <td><?= $isi['nama_uom']; ?></td>
                        <td><?= $isi['batas_aman']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $isi['recid']; ?>"
                                data-kode="<?= $isi['kode_uom']; ?>"
                                data-nama="<?= $isi['nama_uom']; ?>"
                                data-batas="<?= $isi['batas_aman']; ?>">
                                Edit
                            </button>
                            <a href="fungsi/hapus/hapus.php?uom=hapus&id=<?= $isi['recid']; ?>"
                                onclick="return confirm('Hapus data UOM?');">
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
            <form id="form-uom" action="fungsi/tambah/tambah.php?uom=tambah" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="recid" id="input-id">
                    <table class="table table-bordered">
                        <tr>
                            <td>Kode UOM</td>
                            <td><input type="text" name="kode_uom" id="input-kode" class="form-control" required></td>
                        </tr>
                        <tr>
                            <td>Nama UOM</td>
                            <td><input type="text" name="nama_uom" id="input-nama" class="form-control" required></td>
                        </tr>
                        <tr>
                            <td>Batas Aman</td>
                            <td><input type="number" name="batas_aman" id="input-batas" class="form-control" required min="0"></td>
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

<!-- JQuery Script -->
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            $('#modal-title').html('<i class="fa fa-edit"></i> Edit Unit of Measure');
            $('#form-uom').attr('action', 'fungsi/edit/edit.php?uom=edit');
            $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

            $('#input-id').val($(this).data('id'));
            $('#input-kode').val($(this).data('kode'));
            $('#input-nama').val($(this).data('nama'));
            $('#input-batas').val($(this).data('batas'));
        });

        $('[data-target="#myModal"]:not(.btn-edit)').on('click', function() {
            $('#modal-title').html('<i class="fa fa-plus"></i> Tambah Unit of Measure');
            $('#form-uom').attr('action', 'fungsi/tambah/tambah.php?uom=tambah');
            $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
            $('#form-uom')[0].reset();
        });
    });
</script>