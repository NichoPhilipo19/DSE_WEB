<?php
$id = $_GET['product']; // ambil id produk dari URL
$product = $lihat->getProductById($id); // ambil detail produk
$formulasi = $lihat->getFormulasiByProduct($id); // ambil daftar formulasi produk
?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'formulasi') { ?>
	<div class="alert alert-success">
		<p>Tambah formulasi Berhasil!</p>
	</div>
<?php } ?>
<?php if (isset($_GET['success']) && $_GET['success'] == 'hapus') { ?>
	<div class="alert alert-success">
		<p>Hapus formulasi Berhasil!</p>
	</div>
<?php } ?>
<a href="index.php?page=product" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
<h4>Detail Produk & Formulasi</h4>

<div class="card card-body">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<td>Nama Produk</td>
				<td><?= $product['nama_product'] ?></td>
			</tr>
			<tr>
				<td>Deskripsi</td>
				<td><?= $product['desc_product'] ?></td>
			</tr>
			<tr>
				<td>Grade</td>
				<td><?= $product['grade'] ?></td>
			</tr>
			<tr>
				<td>Level</td>
				<td><?= $product['level'] ?></td>
			</tr>
		</table>
	</div>
</div>

<hr />

<!-- Tombol untuk tambah formulasi -->
<button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#modalTambahFormulasi">
	<i class="fa fa-plus"></i> Tambah Formulasi
</button>
<a href="index.php?page=product/details&product=<?= $id ?>" class="btn btn-success btn-md">
	<i class="fa fa-refresh"></i> Refresh Data
</a>

<br /><br />

<!-- Tabel Daftar Formulasi -->
<div class="card card-body">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-sm">
			<thead>
				<tr style="background:#DFF0D8;color:#333;">
					<th>No.</th>
					<th>Nama Bahan Baku</th>
					<th>Qty per Ton</th>
					<th>Satuan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				foreach ($formulasi as $f) {
				?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= $f['nama_bb'] ?></td>
						<td><?= $f['qty_per_ton'] ?></td>
						<td><?= $f['uom'] ?></td>
						<td>
							<a href="fungsi/hapus/hapus.php?formulasi=hapus&id=<?= $f['recid'] ?>&productt=<?= $id ?>"
								onclick="return confirm('Hapus bahan ini dari formulasi?')"
								class="btn btn-danger btn-xs">Hapus</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal Tambah Formulasi -->
<div class="modal fade" id="modalTambahFormulasi" tabindex="-1" role="dialog" aria-labelledby="formulasiModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="fungsi/tambah/tambah.php?formulasi=tambah" method="POST">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Tambah Formulasi Bahan Baku</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="produk_id" value="<?= $id ?>">

					<div class="form-group">
						<label>Bahan Baku</label>
						<select id="bahanbaku_id" name="bahanbaku_id" class="form-control" required>
							<option value="" disabled selected>Pilih bahan baku</option>
							<?php
							$bahanbaku = $lihat->bahanbaku();
							$used_bb_ids = array_column($formulasi, 'bahanbaku_id');
							foreach ($bahanbaku as $bb) {
								$used = in_array($bb['recid'], $used_bb_ids);
								$disabled = $used ? 'disabled' : '';
								echo "<option value='{$bb['recid']}' data-uom='{$bb['satuan']}' $disabled>{$bb['nama_bb']} ({$bb['satuan']})" . ($used ? " - Sudah Dipakai" : "") . "</option>";
							}

							?>
						</select>
					</div>

					<div class="form-group">
						<label>Qty per Ton</label>
						<input type="number" step="0.001" name="qty_per_ton" class="form-control" required>
					</div>

					<div class="form-group">
						<label>Satuan</label>
						<input type="text" id="uom" name="uom" class="form-control" readonly required>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#bahanbaku_id').change(function() {
			var selectedOption = $(this).find('option:selected');
			var uom = selectedOption.data('uom');
			$('#uom').val(uom);
		});
	});
</script>