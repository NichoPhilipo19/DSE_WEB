<h4>Data Nomor Urut</h4>
<br />
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">
        <p>Tambah Nomor Urut Berhasil !</p>
    </div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger">
        <p>Hapus Nomor Urut Berhasil !</p>
    </div>
<?php } ?>

<button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> Insert Data</button>

<a href="index.php?page=number_sequence" class="btn btn-success btn-md">
    <i class="fa fa-refresh"></i> Refresh Data</a>

<br /><br />
<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No.</th>
                    <th>Nomor Dokumen</th>
                    <th>Prefix</th>
                    <th>Kode Perusahaan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Numbering</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hasil = $lihat->numberSequence();
                $no = 1;
                foreach ($hasil as $isi) {
                    $nomor_dokumen = str_pad($isi['last_number'], 4, '0', STR_PAD_LEFT) . "/" . $isi['prefix'] . "/" . $isi['kode_perusahaan'] . "-" . $isi['bulan'] . "/" . $isi['tahun'];
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $nomor_dokumen; ?></td>
                        <td><?= $isi['prefix']; ?></td>
                        <td><?= $isi['kode_perusahaan']; ?></td>
                        <td><?= $isi['bulan']; ?></td>
                        <td><?= $isi['tahun']; ?></td>
                        <td><?= $isi['last_number']; ?></td>
                        <td>
                            <button
                                class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $isi['recid']; ?>"
                                data-aktif="<?= $isi['last_number']; ?>">Edit</button>
                            <a href="fungsi/hapus/hapus.php?number_sequence=hapus&id=<?= $isi['recid']; ?>"
                                onclick="return confirm('Hapus Data ?');">
                                <button class="btn btn-danger btn-xs">Hapus</button>
                            </a>
                        </td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header" style="background:#285c64;color:#fff;">
                <h5 class="modal-title" id="modal-title"><i class="fa fa-plus"></i> Tambah Number Sequence</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form-inventaris" action="fungsi/tambah/tambah.php?number_sequence=tambah" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="input-id">

                    <table class="table table-striped bordered">
                        <tr>
                            <td>Kode Perusahaan</td>
                            <td><input type="text" required class="form-control" name="kode_pt" id="input-kode-pt"></td>
                        </tr>
                        <tr>
                            <td>Prefix</td>
                            <td><input type="text" required class="form-control" name="prefix" id="input-prefix"></td>
                        </tr>
                        <tr>
                            <td>Bulan</td>
                            <td><input type="number" required class="form-control" name="bulan" id="input-bulan"></td>
                        </tr>
                        <tr>
                            <td>Tahun</td>
                            <td><input type="number" required class="form-control" name="tahun" id="input-tahun"></td>
                        </tr>
                        <tr>
                            <td>Numbering</td>
                            <td><input type="text" required class="form-control" name="numbering" id="input-numbering"></td>
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
$(document).ready(function () {
    // Saat tombol Insert/Edit diklik
    $('[data-target="#myModal"]').on('click', function () {
        const isEdit = $(this).hasClass('btn-edit');

        if (isEdit) {
            // Mode Edit
            $('#modal-title').html('<i class="fa fa-edit"></i> Edit Number Sequence');
            $('#form-inventaris').attr('action', 'fungsi/edit/edit.php?number_sequence=edit');

            // Ambil data dari atribut tombol edit
            const id = $(this).data('id');
            const numbering = $(this).data('aktif');
            const kode = $(this).closest('tr').find('td:eq(3)').text();
            const prefix = $(this).closest('tr').find('td:eq(2)').text();
            const bulan = $(this).closest('tr').find('td:eq(4)').text();
            const tahun = $(this).closest('tr').find('td:eq(5)').text();

            // Isi input field
            $('#input-id').val(id);
            $('#input-kode-pt').val(kode);
            $('#input-prefix').val(prefix);
            $('#input-bulan').val(bulan);
            $('#input-tahun').val(tahun);
            $('#input-numbering').val(numbering);

            // Disable semua kecuali input numbering
            $('#input-kode-pt, #input-prefix, #input-bulan, #input-tahun').prop('disabled', true);
            $('#input-numbering').prop('disabled', false);

            $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

        } else {
            // Mode Tambah
            $('#modal-title').html('<i class="fa fa-plus"></i> Tambah Number Sequence');
            $('#form-inventaris').attr('action', 'fungsi/tambah/tambah.php?number_sequence=tambah');

            // Reset form
            $('#form-inventaris')[0].reset();
            $('#input-id').val('');

            // Enable semua input
            $('#input-kode-pt, #input-prefix, #input-bulan, #input-tahun, #input-numbering').prop('disabled', false);

            $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
        }
    });
});
</script>

