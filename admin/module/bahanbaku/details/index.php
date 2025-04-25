<?php
$id = $_GET['bahanbaku'];
$hasil = $lihat->bahanbaku_edit($id);
?>
<a href="index.php?page=bahanbaku" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
<h4>Detail Bahan Baku</h4>
<div class="card card-body">
	<div class="table-responsive">
		<table class="table table-striped">

			<tr>
				<td>Nama Bahan Baku</td>
				<td><?php echo $hasil['nama_bb']; ?></td>
			</tr>
			<tr>
				<td>Deskripsi</td>
				<td><?php echo $hasil['desc']; ?></td>
			</tr>
			<tr>
				<td>Stok</td>
				<td>
					<?php echo $hasil['stok']?>
				</td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><?php echo $hasil['nama_supplier']; ?></td>
			</tr>
			<tr>
				<td>Satuan</td>
				<td><?php echo $hasil['satuan']; ?></td>
			</tr>
		</table>
	</div>
</div>