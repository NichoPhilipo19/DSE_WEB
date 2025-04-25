        <h4>Data Bahan Baku</h4>
        <br />
        <?php if (isset($_GET['success-stok'])) { ?>
            <div class="alert alert-success">
                <p>Tambah Stok Berhasil !</p>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success">
                <p>Tambah Data Berhasil !</p>
            </div>
        <?php } ?>
        <?php if (isset($_GET['remove'])) { ?>
            <div class="alert alert-danger">
                <p>Hapus Data Berhasil !</p>
            </div>
        <?php } ?>

        <?php
        $sql = " select * from tbl_bahan_baku where stok <= 3";
        $row = $config->prepare($sql);
        $row->execute();
        $r = $row->rowCount();
        if ($r > 0) {
            echo "
				<div class='alert alert-warning'>
					<span class='glyphicon glyphicon-info-sign'></span> Ada <span style='color:red'>$r</span> barang yang Stok tersisa sudah kurang dari 3 items. silahkan pesan lagi !!
					<span class='pull-right'><a href='index.php?page=barang&stok=yes'>Cek Barang <i class='fa fa-angle-double-right'></i></a></span>
				</div>
				";
        }
        ?>
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
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
                                <td>
                                    <?php if ($isi['stok'] <=  '3') { ?>
                                        <form method="POST" action="fungsi/edit/edit.php?stok=edit">
                                            <!-- <input type="text" name="restok" class="form-control">
                                            <input type="hidden" name="id" value="<?php echo $isi['recid']; ?>"
                                                class="form-control"> -->
                                            <button class="btn btn-primary btn-sm">
                                                Restok
                                            </button>
                                            <a href="fungsi/hapus/hapus.php?bahanbaku=hapus&id=<?php echo $isi['recid']; ?>"
                                                onclick="javascript:return confirm('Hapus Data bahanbaku ?');">
                                                <button class="btn btn-danger btn-sm">Hapus</button></a>
                                        </form>
                                    <?php } else { ?>
                                        <a href="index.php?page=bahanbaku/details&bahanbaku=<?php echo $isi['recid']; ?>"><button
                                                class="btn btn-primary btn-xs">Details</button></a>

                                        <a href="index.php?page=bahanbaku/edit&bahanbaku=<?php echo $isi['recid']; ?>"><button
                                                class="btn btn-warning btn-xs">Edit</button></a>
                                        <a href="fungsi/hapus/hapus.php?bahanbaku=hapus&id=<?php echo $isi['recid']; ?>"
                                            onclick="javascript:return confirm('Hapus Data barang ?');"><button
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
                    <form action="fungsi/tambah/tambah.php?bahanbaku=tambah" method="POST">
                        <div class="modal-body">
                            <table class="table table-striped bordered">

                                <!-- <tr>
                                    <td>ID Barang</td>
                                    <td><input type="text" readonly="readonly" required value="<?php echo $format; ?>"
                                            class="form-control" name="id"></td>
                                </tr> -->

                                <tr>
                                    <td>Nama Bahan Baku</td>
                                    <td><input type="text" placeholder="Nama Bahan Baku" required class="form-control"
                                            name="nama"></td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td><input type="text" placeholder="Deskripsi" required class="form-control"
                                            name="desc"></td>
                                </tr>
                                <tr>
                                    <td>Satuan Barang</td>
                                    <td>
                                        <select name="satuan" class="form-control" required>
                                            <option value="#">Pilih Satuan</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Ton">Ton</option>
                                            <option value="Liter">Liter</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stok</td>
                                    <td><input type="text" placeholder="Stok" readonly class="form-control"
                                            name="stok" value="0"></td>
                                </tr>
                                <tr>
                                    <td>Supplier</td>
                                    <td>
                                        <select name="supplier" class="form-control" required>
                                            <option value="#">Pilih Supplier</option>
                                            <?php $kat = $lihat->supplier();
                                            foreach ($kat as $isi) {     ?>
                                                <option value="<?php echo $isi['recid']; ?>">
                                                    <?php echo $isi['nama_supplier']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Insert
                                Data</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>