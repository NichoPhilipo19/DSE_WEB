 <!--sidebar end-->

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
 <!--main content start-->
 <?php 
	$id = $_GET['bahanbaku'];
	$hasil = $lihat -> bahanbaku_edit($id);

?>
 <a href="index.php?page=bahanbaku" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
 <h4>Edit Bahan Baku</h4>
 <?php if(isset($_GET['success'])){?>
 <div class="alert alert-success">
     <p>Edit Data Berhasil !</p>
 </div>
 <?php }?>
 <?php if(isset($_GET['remove'])){?>
 <div class="alert alert-danger">
     <p>Hapus Data Berhasil !</p>
 </div>
 <?php }?>
<div class="card card-body">
	<div class="table-responsive">
		<table class="table table-striped">
			<form action="fungsi/edit/edit.php?bahanbaku=edit" method="POST">
				<!-- <tr>
					<td>ID Barang</td> 
					<td>-->
						<input type="hidden" readonly="readonly" class="form-control" value="<?php echo $hasil['recid'];?>"
							name="recid">
				<!-- 	</td>
					</tr> -->
				
				<tr>
					<td>Nama Bahan Baku</td>
					<td><input type="text" class="form-control" value="<?php echo $hasil['nama_bb'];?>" 
					name="nama">
				</td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td><input type="text" class="form-control" value="<?php echo $hasil['desc'];?>" 
					name="desc">
				</td>
				</tr>
				<tr>
					<td>Satuan Barang</td>
					<td>
						<select name="satuan" class="form-control">
							<option value="<?php echo $hasil['satuan'];?>"><?php echo $hasil['satuan'];?>
							</option>
							<option value="#">Pilih Satuan</option>
							<option value="Kg">Kg</option>
                            <option value="Ton">Ton</option>
                            <option value="Liter">Liter</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Stok</td>
					<td><input type="number" class="form-control" value="<?php echo $hasil['stok'];?>" name="stok"></td>
				</tr>
				<tr>
					<td>Supplier</td>
					<td>
						<select name="supplier" class="form-control">
							<option value="<?php echo $hasil['supp_id'];?>"><?php echo $hasil['nama_supplier'];?></option>
							<option value="#">Pilih Supplier</option>
							<?php  $kat = $lihat -> supplier(); foreach($kat as $isi){ 	?>
							<option value="<?php echo $isi['recid'];?>"><?php echo $isi['nama_supplier'];?></option>
							<?php }?>
						</select>
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