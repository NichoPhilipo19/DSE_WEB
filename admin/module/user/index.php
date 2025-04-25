<h4>Data User</h4>
<br />
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success"><p>Tambah User Berhasil!</p></div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger"><p>Hapus User Berhasil!</p></div>
<?php } ?>

<button 
    type="button" 
    class="btn btn-primary" 
    data-toggle="modal" 
    data-target="#myModal">
    <i class="fa fa-plus"></i> Insert Data</button>
<a href="index.php?page=user" class="btn btn-success"><i class="fa fa-refresh"></i> Refresh</a>
<br /><br />

<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Level</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hasil = $lihat->userList();
                $no = 1;
                foreach ($hasil as $row) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['status'] == 1 ? 'Aktif' : 'Nonaktif'; ?></td>
                        <td><?= ucfirst($row['level']); ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td>
                            <button 
                                type="button"
                                class="btn btn-warning btn-xs btn-edit"
                                data-toggle="modal" data-target="#myModal"
                                data-id="<?= $row['recid']; ?>"
                                data-username="<?= $row['username']; ?>"
                                data-nama="<?= $row['nama']; ?>"
                                data-email="<?= $row['email']; ?>"
                                data-status="<?= $row['status']; ?>"
                                data-level="<?= $row['level']; ?>"
                                data-alamat="<?= $row['alamat']; ?>">
                                Edit
                            </button>
                            <a href="fungsi/hapus/hapus.php?user=hapus&id=<?= $row['recid']; ?>"
                                onclick="return confirm('Hapus data user?');">
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
        <h5 class="modal-title" id="modal-title"><i class="fa fa-plus"></i> Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="form-user" action="fungsi/tambah/tambah.php?user=tambah" method="POST">
        <div class="modal-body">
          <input type="hidden" name="recid" id="input-id">
          <table class="table table-bordered">
            <tr><td>Username</td><td><input type="text" name="username" id="input-username" class="form-control" required></td></tr>
            <tr><td>Nama</td><td><input type="text" name="nama" id="input-nama" class="form-control" required></td></tr>
            <tr><td>Email</td><td><input type="email" name="email" id="input-email" class="form-control" required></td></tr>
            <tr><td>Password</td><td><input type="password" name="password" id="input-password" class="form-control"></td></tr>
            <tr>
              <td>Status</td>
              <td>
                <select name="status" id="input-status" class="form-control" required>
                  <option value="">- Pilih Status -</option>
                  <option value="1">Aktif</option>
                  <option value="0">Nonaktif</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Level</td>
              <td>
                <select name="level" id="input-level" class="form-control" required>
                  <option value="">- Pilih Level -</option>
                  <option value="admin">Admin</option>
                  <option value="staff">Staff</option>
                </select>
              </td>
            </tr>
            <tr><td>Alamat</td><td><input type="text" name="alamat" id="input-alamat" class="form-control"></td></tr>
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

<!-- PENTING: Tambahkan ini di bawah -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#btn-add').on('click', function() {
        $('#modal-title').html('<i class="fa fa-plus"></i> Tambah User');
        $('#form-user').attr('action', 'fungsi/tambah/tambah.php?user=tambah');
        $('#btn-submit').html('<i class="fa fa-plus"></i> Insert Data');
        $('#form-user')[0].reset();

        $('#input-username').prop('disabled', false);
        $('#input-nama').prop('disabled', false);
        $('#input-level').prop('disabled', false);
        $('#input-password').prop('disabled', false);
    });

    $('.btn-edit').on('click', function() {
        $('#modal-title').html('<i class="fa fa-edit"></i> Edit User');
        $('#form-user').attr('action', 'fungsi/edit/edit.php?user=edit');
        $('#btn-submit').html('<i class="fa fa-save"></i> Update Data');

        $('#input-id').val($(this).data('id'));
        $('#input-username').val($(this).data('username')).prop('disabled', true);
        $('#input-nama').val($(this).data('nama')).prop('disabled', true);
        $('#input-email').val($(this).data('email'));
        $('#input-status').val($(this).data('status'));
        $('#input-level').val($(this).data('level')).prop('disabled', true);
        $('#input-alamat').val($(this).data('alamat'));
        $('#input-password').val('').prop('disabled', true);
    });
});
</script>
