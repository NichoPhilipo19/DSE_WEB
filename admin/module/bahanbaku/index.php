        <h4>Data Bahan Baku</h4>
        <br />
        <?php if (isset($_GET['success-stok'])) { ?>
            <div class="alert alert-success">
                <p>Tambah Stok Berhasil !</p>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success']) && $_GET['success'] === "tambah") { ?>
            <div class="alert alert-success">
                <p>Tambah Data Berhasil !</p>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success']) && $_GET['success'] === "edit") { ?>
            <div class="alert alert-success">
                <p>Update Data Berhasil !</p>
            </div>
        <?php } ?>
        <?php if (isset($_GET['remove'])) { ?>
            <div class="alert alert-danger">
                <p>Hapus Data Berhasil !</p>
            </div>
        <?php } ?>

        <?php
        $r = $lihat->cekstok();
        if ($r > 0) {
            echo "
				<div class='alert alert-warning'>
					<span class='glyphicon glyphicon-info-sign'></span> Ada <span style='color:red'>$r</span> bahan baku yang Stok nya tersisa sudah kurang dari batas aman produksi. silahkan pesan lagi !!
				</div>
				";
        }
        ?>
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-md mr-2 btn-add" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-plus"></i> Insert Data</button>

        <a href="index.php?page=bahanbaku" class="btn btn-success btn-md">
            <i class="fa fa-refresh"></i> Refresh Data</a>
        <div class="clearfix"></div>
        <br />
        <!-- view barang -->
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" id="example1">
                    <thead>
                        <tr style="background:#DFF0D8;color:#333;">
                            <th>No.</th>
                            <th>Nama Bahan Baku</th>
                            <th>Deskripsi</th>
                            <th>Stok</th>
                            <th>Supplier</th>
                            <th>Satuan</th>
                            <th>Harga Beli per Satuan</th>
                            <th>Harga Jual per Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hasil = $lihat->bahanbaku();

                        $no = 1;
                        foreach ($hasil as $isi) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $isi['nama_bb']; ?></td>
                                <td><?php echo $isi['desc']; ?></td>
                                <td>
                                    <?php if ($isi['stok'] > $isi['batas_aman']) { ?>
                                        <button class="btn btn-waring"> <?php echo $isi['stok']; ?> </button>
                                    <?php } else { ?>
                                        <?php echo $isi['stok']; ?>
                                    <?php } ?>
                                </td>
                                <td><?php echo $isi['nama_supplier']; ?></td>
                                <td><?php echo $isi['satuan']; ?></td>
                                <td>Rp <?= number_format($isi['harga_beli'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($isi['harga_pasaran_per_satuan'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($isi['stok'] <=  $isi['batas_aman']) { ?>

                                        <a href="index.php?page=transaksi_bahan_baku&openModal=tambah&recid=<?php echo $isi['recid']; ?>"
                                            onclick="javascript:return confirm('Order Bahan Baku?');">
                                            <button class="btn btn-primary btn-sm">
                                                Restok
                                            </button>
                                        </a>
                                        <a href="fungsi/hapus/hapus.php?bahanbaku=hapus&id=<?php echo $isi['recid']; ?>"
                                            onclick="javascript:return confirm('Hapus Data bahanbaku ?');">
                                            <button class="btn btn-danger btn-sm">Hapus</button></a>

                                    <?php } else { ?>
                                        <a href="index.php?page=bahanbaku/details&bahanbaku=<?php echo $isi['recid']; ?>"><button
                                                class="btn btn-primary btn-xs">Details</button></a>
                                        <button
                                            data-toggle="modal" data-target="#myModal"
                                            class="btn btn-warning btn-xs btn-edit"
                                            data-id="<?php echo $isi['recid']; ?>"
                                            data-nama="<?php echo $isi['nama_bb']; ?>"
                                            data-desc="<?php echo $isi['desc']; ?>"
                                            data-satuan="<?php echo $isi['satuan']; ?>"
                                            data-supplier="<?php echo $isi['supp_id']; ?>"
                                            data-hargabeli="<?php echo $isi['harga_beli']; ?>"
                                            data-harga="<?php echo $isi['harga_pasaran_per_satuan']; ?>">Edit</button>
                                        <a href="fungsi/hapus/hapus.php?bahanbaku=hapus&id=<?php echo $isi['recid']; ?>"
                                            onclick="javascript:return confirm('Hapus Data Bahan baku ?');"><button
                                                class="btn btn-danger btn-xs">Hapus</button></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end view barang -->
        <!-- tambah barang MODALS-->
        <!-- Modal -->

        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style=" border-radius:0px;">
                    <div class="modal-header" style="background:#285c64;color:#fff;">
                        <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Bahan Baku</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="form-bahanbaku" action="fungsi/tambah/tambah.php?bahanbaku=tambah" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit-id">
                            <table class="table table-striped bordered">
                                <tr>
                                    <td>Nama Bahan Baku</td>
                                    <td><input id="nama" type="text" placeholder="Nama Bahan Baku" required class="form-control"
                                            name="nama"></td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td><input id="desc" type="text" placeholder="Deskripsi" required class="form-control"
                                            name="desc"></td>
                                </tr>
                                <tr>
                                    <td>Satuan / UOM</td>
                                    <td>
                                        <select id="satuan" name="satuan" class="form-control" required>
                                            <option value="#">Pilih Satuan</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Ton">Ton</option>
                                            <option value="Liter">Liter</option>
                                        </select>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Stok</td>
                                    <td><input type="text" placeholder="Stok" readonly class="form-control"
                                            name="stok" value="0"></td>
                                </tr> -->
                                <tr>
                                    <td>Supplier</td>
                                    <td>
                                        <select id="supplier" name="supplier" class="form-control" required>
                                            <option value="#">Pilih Supplier</option>
                                            <?php $kat = $lihat->supplier();
                                            foreach ($kat as $isi) {     ?>
                                                <option value="<?php echo $isi['recid']; ?>">
                                                    <?php echo $isi['nama_supplier']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Harga Beli per Satuan</td>
                                    <td>
                                        <input type="text" class="form-control" id="input-harga-beli-format" required>
                                        <input type="hidden" name="harga_beli" id="input-harga-beli"> <!-- ini yang dikirim ke PHP -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Harga Jual per Satuan</td>
                                    <td>
                                        <input type="text" class="form-control" id="input-harga-format" required>
                                        <input type="hidden" name="harga" id="input-harga"> <!-- ini yang dikirim ke PHP -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button id="btn-submit" type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Insert
                                Data</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
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
                $('[data-toggle="modal"]').on('click', function() {
                    const isEdit = $(this).hasClass('btn-edit');
                    if (isEdit) {
                        const data = $(this).data();
                        $('.modal-title').text('Edit Bahan Baku');
                        $('#form-bahanbaku').attr('action', 'fungsi/edit/edit.php?bahanbaku=edit');
                        $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

                        var harga = data.harga.toString();
                        var hargabeli = data.hargabeli.toString();
                        $('#edit-id').val(data.id);
                        $('#nama').val(data.nama).prop('readonly', true);
                        $('#desc').val(data.desc);
                        $('#satuan').val(data.satuan);
                        $('#supplier').val(data.supplier);
                        $('#input-harga-format').val(formatRupiah(harga));
                        $('#input-harga').val(harga);
                        $('#input-harga-beli-format').val(formatRupiah(hargabeli));
                        $('#input-harga-beli').val(hargabeli);

                        $('#myModal').modal('show');
                    } else {
                        $('.modal-title').html('<i class="fa fa-plus"></i> Tambah Bahan Baku');
                        $('#form-produk').attr('action', 'fungsi/tambah/tambah.php?bahanbaku=tambah');
                        $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
                        $('#form-bahanbaku')[0].reset();
                        $('#edit-id').val('');
                        $('#nama').val("").prop('readonly', false);
                    }
                });
                $('#input-harga-format').on('input', function() {
                    let raw = $(this).val().replace(/[^0-9]/g, ''); // Ambil angka mentah
                    $('#input-harga').val(raw); // Simpan ke hidden input
                    $(this).val(formatRupiah(raw)); // Tampilkan format Rupiah
                });
                $('#input-harga-beli-format').on('input', function() {
                    let raw = $(this).val().replace(/[^0-9]/g, ''); // Ambil angka mentah
                    $('#input-harga-beli').val(raw); // Simpan ke hidden input
                    $(this).val(formatRupiah(raw)); // Tampilkan format Rupiah
                });
            });
        </script>