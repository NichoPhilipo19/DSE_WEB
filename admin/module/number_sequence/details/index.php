<?php
$id = $_GET['client'];
$hasil = $lihat->clientList_edit($id);
?>
<a href="index.php?page=client" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
<h4>Details Client</h4>
<?php if (isset($_GET['success-stok'])) { ?>
	<div class="alert alert-success">
		<p>Tambah Inventaris di Client Berhasil !</p>
	</div>
<?php } ?>
<?php if (isset($_GET['success'])) { ?>
	<div class="alert alert-success">
		<p>Tambah Inventaris di Client Berhasil !</p>
	</div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
	<div class="alert alert-danger">
		<p>Hapus Inventaris di Client Berhasil !</p>
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
<button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
	<i class="fa fa-plus"></i> Insert Data</button>
<a href="index.php?page=client/details&client=<?php echo $id; ?>" class="btn btn-success btn-md">
	<i class="fa fa-refresh"></i> Refresh Data </a>
<div class="clearfix"></div>
<br/>
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
						<!-- <td>
                                   <a href="index.php?page=client/details&client=<?php echo $isi['recid']; ?>"><button
                                           class="btn btn-primary btn-xs">Details</button></a>

                                   <a href="index.php?page=client/edit&client=<?php echo $isi['recid']; ?>"><button
                                           class="btn btn-warning btn-xs">Edit</button></a>
                                   <a href="fungsi/hapus/hapus.php?client=hapus&id=<?php echo $isi['recid']; ?>"
                                       onclick="javascript:return confirm('Hapus Data barang ?');"><button
                                           class="btn btn-danger btn-xs">Hapus</button></a>
                               </td> -->
					</tr>
				<?php
					$no++;
				}
				?>
			</tbody>
		</table>
	</div>
</div>