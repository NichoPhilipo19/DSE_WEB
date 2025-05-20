      <h4>Data Client</h4>
      <br />
      <?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success">
              <p>Tambah Client Berhasil !</p>
          </div>
      <?php } ?>
      <?php if (isset($_GET['remove'])) { ?>
          <div class="alert alert-danger">
              <p>Hapus Client Berhasil !</p>
          </div>
      <?php } ?>

      <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
          <i class="fa fa-plus"></i> Insert Data</button>

      <a href="index.php?page=client" class="btn btn-success btn-md">
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
                          <th>Nama Client</th>
                          <th>Alamat</th>
                          <th>Status</th>
                          <th>Email</th>
                          <th>No.Telp</th>
                          <th>Fax</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                        $hasil = $lihat->clietList();

                        $no = 1;
                        foreach ($hasil as $isi) {
                        ?>
                          <tr>
                              <td><?php echo $no; ?></td>
                              <td><?php echo $isi['nama_client']; ?></td>
                              <td><?php echo $isi['alamat']; ?></td>
                              <td>
                                  <?php if ($isi['status'] == '0') { ?>
                                      Tidak Aktif
                                  <?php } else { ?>
                                      Aktif
                                  <?php } ?>
                              </td>
                              <td><?php echo $isi['email']; ?></td>
                              <td><?php echo $isi['no_telp']; ?></td>
                              <td><?php echo $isi['fax']; ?></td>
                              <td>
                                  <a href="index.php?page=client/details&client=<?php echo $isi['recid']; ?>"><button
                                          class="btn btn-primary btn-xs">Details</button></a>

                                  <a href="index.php?page=client/edit&client=<?php echo $isi['recid']; ?>"><button
                                          class="btn btn-warning btn-xs">Edit</button></a>
                                  <a href="fungsi/hapus/hapus.php?client=hapus&id=<?php echo $isi['recid']; ?>"
                                      onclick="javascript:return confirm('Yakin ingin menghapus data terpilih?');"><button
                                          class="btn btn-danger btn-xs">Hapus</button></a>
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
                      <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Client</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <form action="fungsi/tambah/tambah.php?client=tambah" method="POST">
                      <div class="modal-body">
                          <table class="table table-striped bordered">

                              <!-- <tr>
                                    <td>ID Barang</td>
                                    <td><input type="text" readonly="readonly" required value="<?php echo $format; ?>"
                                            class="form-control" name="id"></td>
                                </tr> -->

                              <tr>
                                  <td>Nama Client</td>
                                  <td><input type="text" placeholder="Nama Client" required class="form-control"
                                          name="nama" required></td>
                              </tr>
                              <tr>
                                  <td>Alamat</td>
                                  <td><input type="textarea" placeholder="Alamat" required class="form-control"
                                          name="alamat" required></td>
                              </tr>
                              <tr>
                                  <td>Status</td>
                                  <td>
                                      <select id="status" name="status" class="form-control" required>
                                          <option value="#">Pilih Status</option>
                                          <option value="1">Aktif</option>
                                          <option value="0">Nonaktif</option>
                                      </select>
                                  </td>
                              </tr>
                              <tr>
                                  <td>email</td>
                                  <td>
                                      <input type="email" placeholder="Email" class="form-control"
                                          name="email" value="" required>
                                  </td>
                              </tr>
                              <tr>
                                  <td>No Telepon</td>
                                  <td>
                                      <input type="number" placeholder="No.Telp" class="form-control no-arrow"
                                          name="notelp" value="" required>
                                  </td>
                              </tr>
                              <tr>
                                  <td>fax</td>
                                  <td>
                                      <input type="number" placeholder="Fax" class="form-control no-arrow"
                                          name="fax" value="" required>
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
      <style>
          /* Tambahkan class atau bisa juga langsung tanpa class */
          .no-arrow::-webkit-outer-spin-button,
          .no-arrow::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
          }

          .no-arrow {
              -moz-appearance: textfield;
          }
      </style>