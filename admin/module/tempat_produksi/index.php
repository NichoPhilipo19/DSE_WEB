<h4>Data Tempat Produksi</h4>
<br />
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success"><p>Tambah Tempat Produksi Berhasil!</p></div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger"><p>Hapus Tempat Produksi Berhasil!</p></div>
<?php } ?>

<button 
    type="button" 
    class="btn btn-primary" 
    data-toggle="modal" 
    data-target="#myModal">
    <i class="fa fa-plus"></i> Insert Data</button>
<a href="index.php?page=tmpt_produksi" class="btn btn-success"><i class="fa fa-refresh"></i> Refresh</a>
<br /><br />

<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No</th>
                    <th>Nama Tempat Produksi</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $hasil = $lihat->tmptProduksiList(); // pastikan function ini sudah ada
                 $no = 1;
                 foreach ($hasil as $row) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $row['recid']; ?>"
                                data-nama="<?= $row['nama']; ?>"
                                data-alamat="<?= $row['alamat']; ?>">Edit</button>
                            <a href="fungsi/hapus/hapus.php?tempat_produksi=hapus&id=<?= $row['recid']; ?>"
                                onclick="return confirm('Hapus data tempat produksi?');">
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
                <h5 class="modal-title" id="modal-title"><i class="fa fa-plus"></i> Tambah Tempat Produksi</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form-tmpt-produk" action="fungsi/tambah/tambah.php?tempat_produksi=tambah" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="recid" id="input-id">
                    <table class="table table-bordered">
                        <tr><td>Nama Tempat Produksi</td><td><input type="text" name="nama" id="input-nama" class="form-control" required></td></tr>
                        <tr><td>Alamat</td><td><input type="text" name="alamat" id="input-alamat" class="form-control" required></td></tr>
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
            $('#modal-title').html('<i class="fa fa-edit"></i> Edit Tempat Produksi');
            $('#form-tmpt-produk').attr('action', 'fungsi/edit/edit.php?tempat_produksi=edit');
            $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

            $('#input-id').val($(this).data('id'));
            $('#input-nama').val($(this).data('nama'));
            $('#input-alamat').val($(this).data('alamat'));
        });

        $('[data-target="#myModal"]:not(.btn-edit)').on('click', function() {
            $('#modal-title').html('<i class="fa fa-plus"></i> Tambah Tempat Produksi');
            $('#form-tmpt-produk').attr('action', 'fungsi/tambah/tambah.php?tempat_produksi=tambah');
            $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
        });
    });
</script>
