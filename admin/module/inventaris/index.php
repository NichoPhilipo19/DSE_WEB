<h4>Data Inventaris</h4>
<br />
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">
        <p>Tambah Inventaris Berhasil !</p>
    </div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger">
        <p>Hapus Inventaris Berhasil !</p>
    </div>
<?php } ?>

<button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> Insert Data</button>

<a href="index.php?page=inventaris" class="btn btn-success btn-md">
    <i class="fa fa-refresh"></i> Refresh Data</a>

<br /><br />
<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Rusak</th>
                    <th>Jumlah Aktif</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hasil = $lihat->invenList();
                $no = 1;
                foreach ($hasil as $isi) {
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $isi['nama_inven']; ?></td>
                        <td><?= $isi['desc']; ?></td>
                        <td><?= $isi['jml_rusak']; ?></td>
                        <td><?= $isi['jml_active']; ?></td>
                        <td><?= $isi['jml']; ?></td>
                        <td>
                            <button
                                class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $isi['recid']; ?>"
                                data-nama="<?= $isi['nama_inven']; ?>"
                                data-desc="<?= $isi['desc']; ?>"
                                data-jml="<?= $isi['jml']; ?>"
                                data-rusak="<?= $isi['jml_rusak']; ?>"
                                data-aktif="<?= $isi['jml_active']; ?>">Edit</button>
                            <a href="fungsi/hapus/hapus.php?inventaris=hapus&id=<?= $isi['recid']; ?>"
                                onclick="return confirm('Hapus Data Inventaris ?');">
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
                <h5 class="modal-title" id="modal-title"><i class="fa fa-plus"></i> Tambah Inventaris</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form-inventaris" action="fungsi/tambah/tambah.php?inventaris=tambah" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="input-id">
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
                            <td><input type="number" class="form-control" name="jml_rusak" id="input-rusak" required></td>
                        </tr>
                        <tr id="row-aktif" style="display:none;">
                            <td>Jumlah Aktif</td>
                            <td><input type="number" class="form-control" name="jml_aktif" id="input-aktif" required></td>
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
        function syncJmlValue() {
            let val = $('#input-jml').val();
            $('#hidden-jml').val(val);
        }

        // Sync langsung saat load modal
        $('#input-jml').on('input', syncJmlValue);
        $('#input-rusak, #input-aktif').on('input', function() {
            if ($('#check-edit-aktif-rusak').is(':checked')) {
                let rusak = parseInt($('#input-rusak').val()) || 0;
                let aktif = parseInt($('#input-aktif').val()) || 0;
                $('#input-jml').val(rusak + aktif);
                syncJmlValue(); // update hidden field
            }
        });

        $('#check-edit-aktif-rusak, #check-edit-total').on('change', syncJmlValue);

        // Initial sync saat modal dibuka
        $('[data-toggle="modal"]').on('click', function() {
            setTimeout(syncJmlValue, 200); // tunggu DOM update
        });

        $('[data-toggle="modal"]').on('click', function() {
            const isEdit = $(this).hasClass('btn-edit');
            $('#check-edit-aktif-rusak').prop('checked', false);
            $('#check-edit-total').prop('checked', false);

            if (isEdit) {
                $('#modal-title').html('<i class="fa fa-edit"></i> Edit Inventaris');
                $('#form-inventaris').attr('action', 'fungsi/edit/edit.php?inventaris=edit');
                $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

                $('#input-id').val($(this).data('id'));
                $('#input-nama').val($(this).data('nama'));
                $('#input-desc').val($(this).data('desc'));
                $('#input-jml').val($(this).data('jml'));
                $('#db-jml').val($(this).data('jml'));

                $('#input-rusak').val($(this).data('rusak'));
                $('#input-aktif').val($(this).data('aktif'));

                $('#row-opsi').show();
            } else {
                $('#modal-title').html('<i class="fa fa-plus"></i> Tambah Inventaris');
                $('#form-inventaris').attr('action', 'fungsi/tambah/tambah.php?inventaris=tambah');
                $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
                $('#form-inventaris')[0].reset();
                $('#input-id').val('');
                $('#row-opsi').hide();
                $('#row-rusak').hide();
                $('#row-aktif').hide();
            }

            // Reset enable state
            $('#input-jml').prop('disabled', false);
            $('#input-rusak, #input-aktif').prop('disabled', false);
        });

        $('#check-edit-aktif-rusak').on('change', function() {
            if ($(this).is(':checked')) {
                $('#check-edit-total').prop('checked', false);
                $('#row-rusak, #row-aktif').show();
                $('#input-jml').prop('disabled', true);
                $('#input-rusak, #input-aktif').prop('disabled', false);
            } else {
                $('#row-rusak, #row-aktif').hide();
                $('#input-jml').prop('disabled', false);
            }
        });

        $('#check-edit-total').on('change', function() {
            if ($(this).is(':checked')) {
                $('#check-edit-aktif-rusak').prop('checked', false);
                $('#row-rusak, #row-aktif').show();
                $('#input-jml').prop('disabled', false);
                $('#input-rusak, #input-aktif').prop('disabled', true);
            } else {
                $('#row-rusak, #row-aktif').hide();
            }
        });

        $('#input-jml').on('input', function() {
            if ($('#check-edit-total').is(':checked')) {
                let dbTotal = parseInt($('#db-jml').val());
                let newTotal = parseInt($(this).val());
                let rusak = parseInt($('#input-rusak').val()) || 0;

                // if (newTotal < dbTotal) {
                //     alert("Jumlah total tidak boleh lebih kecil dari jumlah sebelumnya.");
                //     $(this).val(dbTotal);
                //     return;
                // }

                $('#input-aktif').val(newTotal - rusak);
            }
        });

        $('#input-rusak, #input-aktif').on('input', function() {
            if ($('#check-edit-aktif-rusak').is(':checked')) {
                $('#input-jml').prop('disabled', true);
                let total = parseInt($('#input-rusak').val());

                // let rusak = parseInt($('#input-rusak').val()) || 0;
                // let aktif = parseInt($('#input-aktif').val()) || 0;
                // $('#input-jml').val(rusak + aktif);
            }
        });
    });
</script>