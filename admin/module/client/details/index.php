<?php
$id = $_GET['client'];
$hasil = $lihat->clientList_edit($id);
?>
<a href="index.php?page=client" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
<h4>Details Client & Inventaris di Client</h4>
<?php if (isset($_GET['success-stok'])) { ?>
	<div class="alert alert-success">
		<p>Tambah Client di Client Berhasil !</p>
	</div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == "tambah") { ?>
	<div class="alert alert-success">
		<p>Tambah Client di Client Berhasil !</p>
	</div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == "edit") { ?>
	<div class="alert alert-success">
		<p>Edit Client di Client Berhasil !</p>
	</div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == "hapus") { ?>
	<div class="alert alert-danger">
		<p>Hapus Client di Client Berhasil !</p>
	</div>
<?php } ?>
<div class="card card-body">
	<div class="table-responsive">
		<table class="table table-striped">

			<tr>
				<td>Nama Client</td>
				<td><?php echo $hasil['nama_client']; ?></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td><?php echo $hasil['alamat']; ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
					<?php if ($isi['status'] == '0') { ?>
						Tidak Aktif
					<?php } else { ?>
						Aktif
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?php echo $hasil['email']; ?></td>
			</tr>
			<tr>
				<td>No Telepon</td>
				<td><?php echo $hasil['no_telp']; ?></td>
			</tr>
			<tr>
				<td>Fax</td>
				<td><?php echo $hasil['fax']; ?></td>
			</tr>
		</table>
	</div>
</div>
<br />
<hr />
<button type="button" class="btn btn-primary btn-md mr-2 btn-insert" data-toggle="modal" data-target="#myModal">
	<i class="fa fa-plus"></i> Tambah Inventaris di Client</button>
<a href="index.php?page=client/details&client=<?php echo $id; ?>" class="btn btn-success btn-md">
	<i class="fa fa-refresh"></i> Refresh Data </a>
<div class="clearfix"></div>
<br />
<div class="card card-body">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-sm" id="example1">
			<thead>
				<tr style="background:#DFF0D8;color:#333;">
					<th>No.</th>
					<th>Inventaris</th>
					<th>Jumlah Aktif</th>
					<th>Jumlah Nonaktif</th>
					<th>Jumlah Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$hasil = $lihat->client_relasi_inven($id);

				$no = 1;
				foreach ($hasil as $isi) {
				?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $isi['nama_inven']; ?></td>
						<td><?php echo $isi['jml_active']; ?></td>
						<td><?php echo $isi['jml_nonactive']; ?></td>
						<td><?php echo $isi['jml_total']; ?></td>
						<td>
							<!-- Tombol Edit -->

							<button class="btn btn-warning btn-xs btn-edit"
								data-toggle="modal" data-target="#myModal"
								data-id="<?= $isi['recid']; ?>"
								data-invenid="<?= $isi['inven_id']; ?>"
								data-jmlactive="<?= $isi['jml_active']; ?>"
								data-jmlnonactive="<?= $isi['jml_nonactive']; ?>"
								data-jmltotal="<?= $isi['jml_total']; ?>">
								Edit
							</button>

							<!-- Tombol Hapus -->
							<a href="fungsi/hapus/hapus.php?aksi=hapus_inventaris_client&id=<?php echo $isi['recid']; ?>&clientt=<?php echo $id; ?>" onclick="return confirm('Yakin ingin hapus inventaris ini?')">
								<button class="btn btn-danger btn-xs">Hapus</button>
							</a>
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

<!-- Modal Tambah/Edit Inventaris -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="form-relasi" method="post">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-title">Tambah Inventaris ke Client</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="client_id" id="client_id" value="<?= $id ?>" />
					<input type="hidden" name="recid" id="recid" /> <!-- ini perlu untuk edit -->

					<div class="form-group">
						<label>Inventaris</label>
						<select name="inven_id" id="inven_id" class="form-control" required>
							<option value="">-- Pilih Inventaris --</option>
							<?php
							$dataInven = $lihat->invenList();
							foreach ($dataInven as $inv) {
								echo "<option value='{$inv['recid']}'>{$inv['nama_inven']}</option>";
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Jumlah Total</label>
						<input type="number" name="jml_total" id="jml_total" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Jumlah Aktif</label>
						<input type="number" name="jml_active" id="jml_active" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Jumlah Nonaktif</label>
						<input type="number" name="jml_nonactive" id="jml_nonactive" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="btn-submit" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('.btn-edit').on('click', function() {
			$('#modal-title').text('Edit Inventaris');
			$('#form-relasi').attr('action', 'fungsi/edit/edit.php?aksi=edit_inventaris_client');
			$('#btn-submit').text('Update');

			// Ambil data dari data-atribut tombol edit
			$('#recid').val($(this).data('id'));
			$('#client_id').val(<?= $id ?>); // langsung dari PHP
			$('#inven_id').val($(this).data('invenid'));
			$('#jml_total').val($(this).data('jmltotal'));
			$('#jml_active').val($(this).data('jmlactive'));
			$('#jml_nonactive').val($(this).data('jmlnonactive'));
		});

		// Reset saat tambah
		$('.btn-insert').on('click', function() {
			$('#modal-title').text('Tambah Inventaris');
			$('#form-relasi').attr('action', 'fungsi/tambah/tambah.php?aksi=tambah_inventaris_client');
			$('#btn-submit').text('Simpan');
			$('#form-relasi')[0].reset();
			$('#recid').val('');
		});
	});
</script>