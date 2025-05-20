 <!--sidebar end-->

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
 <!--main content start-->
 <?php
	$id = $_GET['client'];
	$hasil = $lihat->clientList_edit($id);

	?>
 <a href="index.php?page=client" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
 <h4>Edit Client</h4>
 <?php if (isset($_GET['success'])) { ?>
 	<div class="alert alert-success">
 		<p>Edit Data Berhasil !</p>
 	</div>
 <?php } ?>
 <?php if (isset($_GET['remove'])) { ?>
 	<div class="alert alert-danger">
 		<p>Hapus Data Berhasil !</p>
 	</div>
 <?php } ?>
 <div class="card card-body">
 	<div class="table-responsive">
 		<table class="table table-striped">
 			<form action="fungsi/edit/edit.php?client=edit" method="POST">
 				<!-- <tr>
					<td>ID Barang</td> 
					<td>-->
 				<input type="hidden" readonly="readonly" class="form-control" value="<?php echo $hasil['recid']; ?>"
 					name="recid" required>
 				<!-- 	</td>
					</tr> -->

 				<tr>
 					<td>Nama Client</td>
 					<td><input type="text" class="form-control" value="<?php echo $hasil['nama_client']; ?>"
 							name="nama" readonly>
 					</td>
 				</tr>
 				<tr>
 					<td>Alamat</td>
 					<td><input type="textarea" class="form-control" value="<?php echo $hasil['alamat']; ?>"
 							name="alamat" required>
 					</td>
 				</tr>
 				<tr>
 					<td>Status</td>
 					<td>
 						<select id="status" name="status" class="form-control" required>
 							<option value="<?php echo $hasil['status']; ?>">
 								<?php
									if ($hasil['status'] == 1) {
										echo "Aktif";
									} else {
										echo "Nonaktif";
									}
									?>
 							</option>
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
 							name="email" value="<?php echo $hasil['email']; ?>" required>
 					</td>
 				</tr>
 				<tr>
 					<td>No Telepon</td>
 					<td>
 						<input type="number" placeholder="No.Telp" class="form-control no-arrow"
 							name="notelp" value="<?php echo $hasil['no_telp']; ?>" required>
 					</td>
 				</tr>
 				<tr>
 					<td>fax</td>
 					<td>
 						<input type="number" placeholder="Fax" class="form-control no-arrow"
 							name="fax" value="<?php echo $hasil['fax']; ?>" required>
 					</td>
 				</tr>
 				<tr>
 					<td></td>
 					<td><button class="btn btn-primary"><i class="fa fa-edit"></i> Update Data</button></td>
 				</tr>
 			</form>
 		</table>
 	</div>
 </div>