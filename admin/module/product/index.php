<h4>Data Produk</h4>
<br />
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">
        <p>Tambah Produk Berhasil!</p>
    </div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger">
        <p>Hapus Produk Berhasil!</p>
    </div>
<?php } ?>

<button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> Insert Data</button>

<a href="index.php?page=product" class="btn btn-success btn-md">
    <i class="fa fa-refresh"></i> Refresh Data</a>

<br /><br />
<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Grade</th>
                    <th>Level</th>
                    <th>Harga Per Ton</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hasil = $lihat->productList();
                $no = 1;
                foreach ($hasil as $isi) {
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $isi['nama_product']; ?></td>
                        <td><?= $isi['desc_product']; ?></td>
                        <td><?= $isi['grade']; ?></td>
                        <td><?= $isi['level']; ?></td>
                        <td>Rp <?= number_format($isi['hargaPerTon'], 0, ',', '.') ?></td>
                        <td>
                            <a href="index.php?page=product/details&product=<?php echo $isi['recid']; ?>"><button
                                    class="btn btn-primary btn-xs">Details</button></a>
                            <button class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $isi['recid']; ?>"
                                data-nama="<?= $isi['nama_product']; ?>"
                                data-desc="<?= $isi['desc_product']; ?>"
                                data-grade="<?= $isi['grade']; ?>"
                                data-level="<?= $isi['level']; ?>"
                                data-harga="<?= $isi['hargaPerTon']; ?>">Edit</button>
                            <a href="fungsi/hapus/hapus.php?product=hapus&id=<?= $isi['recid']; ?>"
                                onclick="return confirm('Hapus Data produk?');">
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
                <h5 class="modal-title" id="modal-title"><i class="fa fa-plus"></i> Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form-produk" action="fungsi/tambah/tambah.php?product=tambah" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="input-id">
                    <table class="table table-striped bordered">
                        <tr>
                            <td>Nama Produk</td>
                            <td><input type="text" required class="form-control" name="nama_product" id="input-nama"></td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td><input type="text" required class="form-control" name="desc_product" id="input-desc"></td>
                        </tr>
                        <tr>
                            <td>Grade</td>
                            <td>
                                <select class="form-control" name="grade" id="input-grade" required>
                                    <option value="">- Pilih Grade -</option>
                                    <?php foreach (['A', 'B', 'C', 'D', 'F', 'G', 'H'] as $g) {
                                        echo "<option value='$g'>$g</option>";
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Level</td>
                            <td>
                                <select class="form-control" name="level" id="input-level" required>
                                    <option value="">- Pilih Level -</option>
                                    <?php foreach (['1', '2', '3', '4'] as $l) {
                                        echo "<option value='$l'>$l</option>";
                                    } ?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>Harga per Ton</td>
                            <td>
                                <input type="text" class="form-control" id="input-harga-format" required>
                                <input type="hidden" name="harga" id="input-harga"> <!-- ini yang dikirim ke PHP -->
                            </td>
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
<!-- jQuery (harus duluan) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (harus setelah jQuery) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Optional: Bootstrap CSS juga, kalau belum -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
        $('[data-toggle="modal"]').on('click', function() {
            const isEdit = $(this).hasClass('btn-edit');
            if (isEdit) {
                $('#modal-title').html('<i class="fa fa-edit"></i> Edit Produk');
                $('#form-produk').attr('action', 'fungsi/edit/edit.php?product=edit');
                $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');
                var harga = $(this).data('harga').toString();
                // alert(harga, formatRupiah(harga));
                $('#input-id').val($(this).data('id'));
                $('#input-nama').val($(this).data('nama'));
                $('#input-desc').val($(this).data('desc'));
                $('#input-grade').val($(this).data('grade'));
                $('#input-level').val($(this).data('level'));
                $('#input-harga-format').val(formatRupiah(harga));
                $('#input-harga').val(harga);
            } else {
                $('#modal-title').html('<i class="fa fa-plus"></i> Tambah Produk');
                $('#form-produk').attr('action', 'fungsi/tambah/tambah.php?product=tambah');
                $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
                $('#form-produk')[0].reset();
                $('#input-id').val('');
            }
        });
        $('#input-harga-format').on('input', function() {
            let raw = $(this).val().replace(/[^0-9]/g, ''); // Ambil angka mentah
            $('#input-harga').val(raw); // Simpan ke hidden input
            $(this).val(formatRupiah(raw)); // Tampilkan format Rupiah
        });
    });
</script>