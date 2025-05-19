 <!--sidebar end-->

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
 <!--main content start-->
 <?php
	$id = $_SESSION['admin']['username'];
	$numbeq = $lihat->numberSequenceForTransaksi();
	?>
 <h4>Penjualan</h4>
 <input type="hidden" class="form-control" id="invoice" value="<? echo $numbeq; ?>">
 <input type="hidden" class="form-control" id="username" value="<? echo $id; ?>">
 <br>
 <?php if (isset($_GET['success']) && $_GET['success'] == 'tambah') { ?>
 	<div class="alert alert-success">
 		<p>Transaksi telah di tambahkan</p>
 	</div>
 <?php } ?>
 <div class="row">
 	<div class="col-sm-12" id="daftar-produk">
 		<div class="card card-primary mb-3">
 			<div class="card-header bg-primary text-white">
 				<h5><i class="fa fa-list"></i> Daftar Produk</h5>
 			</div>
 			<div class="card-body">
 				<div class="table-responsive">
 					<table class="table table-bordered table-striped table-sm" id="table1">
 						<thead>
 							<tr style="background:#DFF0D8;color:#333;">
 								<th>No.</th>
 								<th>Nama Produk</th>
 								<th>Deskripsi</th>
 								<th>Grade</th>
 								<th>Level</th>
 								<th>Harga per Ton</th>
 								<th>Aksi</th>
 							</tr>
 						</thead>
 						<tbody>
 							<?php
								$hasil = $lihat->productList();
								$no = 1;
								foreach ($hasil as $isi) {
								?>
 								<tr data-id="<?= $no; ?>" data-harga="<?= $isi['hargaPerTon'] ?>" data-recid="<?= $isi['recid']; ?>">
 									<td><?= $no; ?></td>
 									<td><?= $isi['nama_product']; ?></td>
 									<td><?= $isi['desc_product']; ?></td>
 									<td><?= $isi['grade']; ?></td>
 									<td><?= $isi['level']; ?></td>
 									<td>Rp <?= number_format($isi['hargaPerTon'], 0, ',', '.') ?></td>
 									<td>
 										<button class="btn btn-warning btn-xs add-row-trigger"

 											data-id="<?= $isi['recid']; ?>"
 											data-nama="<?= $isi['nama_product']; ?>"
 											data-desc="<?= $isi['desc_product']; ?>"
 											data-grade="<?= $isi['grade']; ?>"
 											data-level="<?= $isi['level']; ?>">Tambah ke kasir</button>

 									</td>
 								</tr>
 							<?php $no++;
								} ?>
 						</tbody>
 					</table>
 				</div>
 			</div>
 		</div>
 	</div>


 	<div class="col-sm-12">
 		<div class="card card-primary" id="transaksi_semua">
 			<div class="card-header bg-primary text-white">
 				<h5><i class="fa fa-shopping-cart"></i> Transaksi
 					<a class="btn btn-danger float-right"
 						onclick="javascript:return confirm('Apakah anda ingin reset keranjang ?');" href="fungsi/hapus/hapus.php?penjualan=jual">
 						<b>RESET FORM</b></a>
 				</h5>
 			</div>
 			<div class="card-body">
 				<div id="keranjang" class="table-responsive">
 					<table class="table table-bordered">
 						<tr>
 							<td><b>Tanggal</b></td>
 							<td><input type="text" id="tgl_transaksi" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i"); ?>" name="tgl"></td>
 						</tr>
 					</table>
 					<table class="table table-bordered w-100" id="table2">
 						<thead>
 							<tr>
 								<td> No</td>
 								<td> Nama Product</td>
 								<td style="width:10%;"> Jumlah (Ton's)</td>
 								<td style="width:20%;"> Harga Per Ton</td>
 								<td style="width:20%;"> Harga (by Qty)</td>
 								<td> Aksi</td>
 							</tr>
 						</thead>
 						<tbody>

 						</tbody>
 					</table>
 					<br />
 					<div class="card mt-4" id="input_tambahan">
 						<div class="card-header bg-info text-white">
 							<h5><i class="fa fa-cogs"></i> Detail Tambahan Transaksi</h5>
 						</div>
 						<div class="card-body">
 							<div class="row">
 								<!-- PPn -->
 								<div class="col-md-6">
 									<div class="form-check">
 										<input class="form-check-input" type="checkbox" id="use_ppn">
 										<label class="form-check-label" for="use_ppn">
 											Gunakan PPn 11%
 										</label>
 									</div>
 									<div class="form-group mt-2">
 										<label for="ppn_amount">PPn (11%)</label>
 										<input type="text" class="form-control" id="ppn_amount" readonly value="Rp 0">
 									</div>
 								</div>

 								<!-- Ongkir -->
 								<div class="col-md-6">
 									<div class="form-check">
 										<input class="form-check-input" type="checkbox" id="free_ongkir">
 										<label class="form-check-label" for="free_ongkir">
 											Ongkir ditanggung perusahaan (Gratis)
 										</label>
 									</div>
 									<div class="form-group mt-2">
 										<label for="ongkir">Biaya Ongkir</label>
 										<input type="text" class="form-control" id="ongkir" value="Rp 0">
 										<input type="hidden" class="form-control" id="ongkirNumber" value="0">
 									</div>
 								</div>
 							</div>

 							<div class="row">
 								<!-- Estimasi sampai -->
 								<div class="col-md-6">
 									<div class="form-group">
 										<label for="estimasi_sampai">Estimasi Tanggal Sampai</label>
 										<input type="date" class="form-control" id="estimasi_sampai">
 									</div>
 								</div>

 								<!-- Jatuh tempo -->
 								<div class="col-md-6">
 									<div class="form-check">
 										<input class="form-check-input" type="checkbox" id="gunakan_tagihan">
 										<label class="form-check-label" for="gunakan_tagihan">
 											Menggunakan Tagihan (Bukan Pembayaran di Muka)
 										</label>
 									</div>
 									<div class="form-group mt-2">
 										<label for="jatuh_tempo">Tanggal Jatuh Tempo</label>
 										<input type="date" class="form-control" id="jatuh_tempo">
 									</div>
 								</div>
 							</div>

 							<!-- Inventaris -->
 							<div class="form-check mt-3">
 								<input class="form-check-input" type="checkbox" id="use_inventaris">
 								<label class="form-check-label" for="use_inventaris">
 									Gunakan Inventaris Saat Pengiriman
 								</label>
 							</div>
 							<div id="inventaris_options" style="display:none;" class="mt-3">
 								<label for="inventaris_list">Pilih Inventaris:</label>
 								<table class="table table-bordered" id="tbl-inven">
 									<thead>
 										<tr>
 											<th>Nama Inventaris</th>
 											<th>Qty</th>
 										</tr>
 									</thead>
 									<tbody>
 										<?php
											$inventarisList = $lihat->invenList();
											foreach ($inventarisList as $inv) { ?>
 											<tr>
 												<td>
 													<input type="checkbox" name="inventaris_id[]" value="<?= $inv['recid'] ?>">
 													<?= $inv['nama_inven'] ?>
 												</td>
 												<td><input type="number" name="inventaris_qty[<?= $inv['recid'] ?>]" class="form-control" value="0" min="0"></td>
 											</tr>
 										<?php } ?>
 									</tbody>
 								</table>
 							</div>

 							<div class="row">
 								<!-- Client -->
 								<div class="col-md-6">
 									<label for="client_select">Pilih Client</label>
 									<select id="client_select" class="form-control">
 										<?php $clients = $lihat->clietList();
											foreach ($clients as $c) { ?>
 											<option value="<?= $c['recid'] ?>"><?= $c['nama_client'] ?></option>
 										<?php } ?>
 									</select>
 								</div>

 								<!-- Tempat Produksi -->
 								<div class="col-md-6">
 									<label for="produksi_select">Pilih Tempat Produksi</label>
 									<select id="produksi_select" class="form-control">
 										<?php $produksi = $lihat->tmptProduksiList();
											foreach ($produksi as $p) { ?>
 											<option value="<?= $p['recid'] ?>"><?= $p['nama'] ?></option>
 										<?php } ?>
 									</select>
 								</div>
 							</div>
 						</div>
 					</div>
 					<br />
 					<div id="kasirnya">
 						<table class="table table-stripped">

 							<!-- aksi ke table nota -->

 							<tr>
 								<td>Total Semua </td>
 								<td><input type="text" class="form-control" name="total" id="total_bayar" value="" /></td>

 								</td>
 							</tr>
 							<!-- aksi ke table nota -->
 							<tr>
 								<!-- <td>
 									<a href="print.php?nm_member=<?php echo $_SESSION['admin']['nm_member']; ?>
									&bayar=<?php echo $bayar; ?>&kembali=<?php echo $hitung; ?>" target="_blank">
 										<button class="btn btn-secondary">
 											<i class="fa fa-print"></i> Print Untuk Bukti Pembayaran
 										</button></a>
 								</td> -->
 								<td>
 									<button class="btn btn-success" id="submitAllInput"><i class="fa fa-shopping-cart"></i> Cetak Invoice</button>
 								</td>
 							</tr>
 						</table>
 						<br />
 						<br />
 					</div>
 				</div>
 			</div>
 		</div>
 		<div class="card mt-4" id="previewBahanBakuCard" style="display: none;">
 			<div class="card-header bg-warning text-dark">
 				<h5><i class="fa fa-cubes"></i> Preview Kebutuhan Bahan Baku</h5>
 			</div>
 			<div class="card-body">
 				<div class="table-responsive">
 					<table class="table table-bordered" id="previewBahanBakuTable">
 						<thead>
 							<tr>
 								<th>No</th>
 								<th>Nama Bahan Baku</th>
 								<th>Kebutuhan Total (kg)</th>
 								<th>Stok Tersedia (kg)</th>
 								<th>Status</th>
 								<th>Aksi</th>
 							</tr>
 						</thead>
 						<tbody>
 							<!-- Isi otomatis oleh JS -->
 						</tbody>
 					</table>
 				</div>
 			</div>
 		</div>

 	</div>


 	<script>
 		// AJAX call for autocomplete 
 		$(document).ready(function() {
 			function getValueFromTable() {
 				let total = 0;
 				$('#table2 tbody tr').each(function() {
 					const jumlah = parseFloat($(this).find('input[name="jumlah[]"]').val()) || 0;
 					let hargaStr = $(this).find('input[name="harga[]"]').val();

 					// Convert "Rp 1.000.000" -> 1000000
 					hargaStr = hargaStr.replace(/[^,\d]/g, '').replace(',', '.');
 					const harga = parseFloat(hargaStr) || 0;

 					total += jumlah * harga;
 				});
 				return total;
 			}

 			function updateFinalTotal() {
 				let totalValue = getValueFromTable();
 				let total = parseFloat(totalValue) || 0;
 				let ppn = $('#use_ppn').is(':checked') ? total * 0.11 : 0;
 				let ongkir = $('#free_ongkir').is(':checked') ? 0 : parseFloat($('#ongkirNumber').val()) || 0;

 				$('#ppn_amount').val(formatRupiah(ppn.toString()));

 				let grandTotal = total + ppn + ongkir;
 				// Bisa tampilkan di elemen tambahan jika perlu
 				console.log("Total Akhir:", grandTotal);
 				setTimeout($('#total_bayar').val(formatRupiah(grandTotal.toString())), 1000)
 			}

 			function updateTable2Numbering() {
 				$('#table2 tbody tr').each(function(index) {
 					$(this).find('td.no').text(index + 1);
 				});
 			}

 			function updateTotalBayar() {
 				let total = getValueFromTable();

 				$('#total_bayar').val(formatRupiah(total.toString()));

 				// $('#total_bayar').val(total.toFixed(2));
 			}


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
 			$('#table1').on('click', '.add-row-trigger', function() {
 				var $row = $(this).closest('tr');
 				var id = $row.data('id');
 				var recid = $row.data('recid');
 				var harga = $row.data('harga');

 				// Cek apakah data sudah ada
 				if ($('#table2 tbody tr[data-id="' + id + '"]').length > 0) {
 					alert('Data sudah ada di Table 2!');
 					return;
 				}

 				// Ambil data dari table1
 				var nama = $row.find('td:eq(1)').text();
 				var desc = $row.find('td:eq(2)').text();
 				var grade = $row.find('td:eq(3)').text();
 				var level = $row.find('td:eq(4)').text();
 				var hargaTotal = harga * 0.1;
 				var formatRupiahConvert = formatRupiah(hargaTotal.toString());

 				var newRow = `
					<tr data-id="${id}">
						<td class="no"></td>
						<td>
						${nama}
						<input type="hidden" class="form-control" name="recidProduct[]" readonly value="${recid}" />
						</td>
						<td><input type="number" class="form-control" name="jumlah[]" value="0.1" min="0.1" step="0.1" /></td>
						<td><input type="text" class="form-control" name="harga[]" readonly value="${formatRupiah(harga.toString())}" /></td>
						<td>
							<input type="text" class="form-control" name="hargaTotal[]" readonly value="${formatRupiahConvert}" />
							<input type="hidden" class="form-control" name="hargaTotalFix[]" value="${hargaTotal}" />
						</td>
						<td><button type="button" class="btn btn-danger btn-sm remove-row-trigger">Hapus</button></td>
					</tr>
				`;

 				$('#table2 tbody').append(newRow);

 				// Sembunyikan baris di table1
 				$row.hide();

 				// sementara
 				$("#daftar-produk").hide()
 				// sementara

 				updateTable2Numbering();
 				updateTotalBayar();
 				setTimeout(loadPreviewBahanBaku, 300); // delay agar row sempat masuk
 			});

 			// Hapus baris dari table2
 			$('#table2').on('click', '.remove-row-trigger', function() {
 				var $row = $(this).closest('tr');
 				var id = $row.data('id');

 				// Tampilkan kembali baris di table1
 				$('#table1 tbody tr[data-id="' + id + '"]').show();

 				$row.remove();

 				// sementara
 				$("#daftar-produk").show()
 				// sementara

 				updateTable2Numbering();
 				loadPreviewBahanBaku();
 			});
 			$('#table2').on('input', 'input[name="jumlah[]"]', function() {
 				var $row = $(this).closest('tr');
 				var jumlah = parseFloat($(this).val()) || 0;

 				// Ambil nilai dari input harga yang ada di baris ini
 				var hargaStr = $row.find('input[name="harga[]"]').val();
 				var harga = parseFloat(hargaStr.replace(/[^,\d]/g, '').replace(',', '.')) || 0;

 				// Hitung total harga
 				var total = jumlah * harga;

 				// Update kolom harga total di baris ini
 				$row.find('input[name="hargaTotal[]"]').val(formatRupiah(total.toString()));
 				$row.find('input[name="hargaTotalFix[]"]').val(total);

 				// Update total seluruh tabel
 				updateTotalBayar();
 				setTimeout(loadPreviewBahanBaku, 300);
 			});


 			function loadPreviewBahanBaku() {
 				const kebutuhan = {};
 				console.log("Mulai loadPreviewBahanBaku");

 				$('#table2 tbody tr').each(function() {
 					const idProduct = $(this).data('id');
 					const qtyInput = $(this).find('td:eq(2) input');
 					const qty = parseFloat(qtyInput.val()) || 0;

 					console.log("Fetching untuk", idProduct, "qty:", qty);

 					$.ajax({
 						url: `fungsi/ajax/getData.php?aksi=jual&product_id=${idProduct}&qty=${qty}`,
 						method: 'GET',
 						dataType: 'json',
 						async: false,
 						success: function(data) {
 							console.log("Response dari server:", data);
 							data.forEach(item => {
 								if (!kebutuhan[item.nama_bahan]) {
 									kebutuhan[item.nama_bahan] = {
 										total_kebutuhan: 0,
 										stok: item.stok,
 										recid: item.recid
 									};
 								}
 								kebutuhan[item.nama_bahan].total_kebutuhan += parseFloat(item.kebutuhan);
 							});
 						},
 						error: function(xhr) {
 							console.error("AJAX error:", xhr.responseText);
 						}
 					});
 				});

 				console.log("HASIL kebutuhan:", kebutuhan);

 				// Lanjut render seperti biasa...
 				const $tbody = $('#previewBahanBakuTable tbody');
 				$tbody.empty();

 				let no = 1;
 				let adaKekurangan = false;

 				for (const nama in kebutuhan) {
 					const total = kebutuhan[nama].total_kebutuhan;
 					const stok = kebutuhan[nama].stok;
 					const recid = kebutuhan[nama].recid;
 					const kurang = stok < total;
 					const status = kurang ? 'Stok Kurang' : 'Cukup';
 					var newRow = `<tr>
						<td>${no++}</td>
						<td>${nama}</td>
						<td>${total}</td>
						<td>${stok}</td>
						<td><span class="badge ${kurang ? 'badge-danger' : 'badge-success'}">${status}</span></td>
						<td>
							${kurang ? `<button class="btn btn-sm btn-danger" onclick="window.open('index.php?page=transaksi_bahan_baku&openModal=tambah&recid=${recid}', '_blank')">Order</button>` : ''}
							
						</td>
					</tr>`
 					console.log(newRow, 'newRow')
 					$tbody.append(newRow);
 					if (kurang) adaKekurangan = true;
 				}

 				if (no > 1) {
 					$('#previewBahanBakuCard').show();
 				} else {
 					$('#previewBahanBakuCard').hide();
 				}
 			}

 			// Trigger update setiap kali jumlah berubah atau produk ditambah
 			$('#table2').on('input', 'input[name="jumlah[]"]', loadPreviewBahanBaku);

 			$('#use_ppn, #free_ongkir').on('change input', updateFinalTotal);
 			$('#ongkir').on('input', function() {
 				let raw = $(this).val().replace(/[^0-9]/g, ''); // Ambil angka mentah
 				$('#ongkirNumber').val(raw); // Simpan ke hidden input
 				$(this).val(formatRupiah(raw)); // Tampilkan format Rupiah
 				updateFinalTotal();
 			});
 			// Toggle inventaris
 			$('#use_inventaris').on('change', function() {
 				$('#inventaris_options').toggle(this.checked);
 			});

 			// sementara
 			$('input[name="inventaris_id[]"]').on('change', function() {
 				// Uncheck semua checkbox
 				$('input[name="inventaris_id[]"]').prop('checked', false);
 				// Ceklis hanya yang diklik
 				$(this).prop('checked', true);
 			});
 			// sementara

 			$('#submitAllInput').on('click', function() {

 				const table = document.getElementById("table2");
 				const rows = table.querySelectorAll("tbody tr");

 				let total_harga = 0;
 				const data = [];
 				rows.forEach(row => {
 					const cells = row.querySelectorAll("td");
 					// Pastikan urutan sesuai dengan isi tabel Anda
 					const produk = cells[1]?.innerText.trim();
 					const recid = cells[1]?.querySelector("input")?.value;
 					const jumlah = cells[2]?.querySelector("input")?.value;
 					const harga = cells[3]?.querySelector("input")?.value;
 					const total = cells[4]?.querySelector("input")?.value;
 					var totalReplace = total.replace(/[^0-9]/g, '')
 					total_harga = total_harga + parseInt(totalReplace)
 					data.push({
 						recid: recid,
 						produk: produk,
 						jumlah: jumlah,
 						harga: harga,
 						total: total.replace(/[^0-9]/g, '')
 					});
 				});

 				const table2 = document.getElementById("tbl-inven");
 				const rows2 = table2.querySelectorAll("tbody tr");

 				const data2 = [];
 				rows2.forEach(row => {
 					const cells = row.querySelectorAll("td");
 					// Pastikan urutan sesuai dengan isi tabel Anda
 					const checked = cells[0]?.querySelector("input")?.checked;
 					const recid = cells[0]?.querySelector("input")?.value;
 					const nama_inven = cells[0]?.innerText.trim();
 					const jumlah = cells[1]?.querySelector("input")?.value;

 					data2.push({
 						checked: checked ? 1 : 0,
 						recid: recid,
 						nama_inven: nama_inven,
 						jumlah: jumlah,
 					});
 				});
 				const isPpnChecked = document.getElementById("use_ppn").checked;
 				const isfree_ongkirChecked = document.getElementById("free_ongkir").checked;
 				const isgunakan_tagihanChecked = document.getElementById("gunakan_tagihan").checked;
 				const isuse_inventarisChecked = document.getElementById("use_inventaris").checked;
 				const detailTambahan = {
 					useppn: isPpnChecked ? 1 : 0,
 					ppn: $("#ppn_amount").val().replace(/[^0-9]/g, ''),
 					freeOngkir: isfree_ongkirChecked ? 1 : 0,
 					ongkir: $("#ongkirNumber").val(),
 					tgl_transaksi: $("#tgl_transaksi").val(),
 					estimasi: $("#estimasi_sampai").val(),
 					bayarDimuka: isgunakan_tagihanChecked ? 1 : 0,
 					jatuh_tempo: $("#jatuh_tempo").val(),
 					use_inventaris: isuse_inventarisChecked ? 1 : 0,
 					client_select: $("#client_select").val(),
 					produksi_select: $("#produksi_select").val(),
 					total_semua: $("#total_bayar").val().replace(/[^0-9]/g, ''),
 				}


 				const payload = {
 					tgl: detailTambahan.tgl_transaksi,
 					no_invoice: $("#invoice").val(),
 					harga: data[0].harga,
 					ppn: detailTambahan.ppn,
 					qty: data[0].jumlah,
 					total_harga: total_harga,
 					pengiriman: "Kurir Internal",
 					ongkir: detailTambahan.ongkir,
 					penanggung_ongkir: detailTambahan.freeOngkir,
 					tanggal_sampai: detailTambahan.estimasi,
 					tgl_jatuh_tempo: detailTambahan.jatuh_tempo,
 					status_pembayaran: detailTambahan.bayarDimuka,
 					sisa_pembayaran: 100,
 					sudah_diterima: 0,
 					pakai_inventaris: detailTambahan.use_inventaris,
 					inven_id: data2[0].recid,
 					jml_inven: data2[0].jumlah,
 					client_id: detailTambahan.client_select,
 					product_id: data[0].recid,
 					tgl_produksi: detailTambahan.tgl_transaksi,
 					tmpt_produksi_id: detailTambahan.produksi_select,
 					status_produksi: 0,
 					createdby: $("#username").val(),
 					modifiedby: $("#username").val(),

 					// dataInventaris: data2.filter(obj => obj.checked === 1),
 					// detail: detailTambahan

 				};
 				console.log(payload)
 				fetch("fungsi/tambah/tambah.php?jual=tambah", {
 						method: "POST",
 						headers: {
 							"Content-Type": "application/json"
 						},
 						body: JSON.stringify(payload)
 					})
 					.then(res => res.text())
 					.then(result => {
 						alert("Data berhasil dikirim!");
 						console.log(result);
 					})
 					.catch(error => {
 						console.error("Gagal:", error);
 					});

 			});
 			// $('#submitAllInput').on('click', function() {

 			// 	const table = document.getElementById("table2");
 			// 	const rows = table.querySelectorAll("tbody tr");

 			// 	const data = [];
 			// 	rows.forEach(row => {
 			// 		const cells = row.querySelectorAll("td");
 			// 		// Pastikan urutan sesuai dengan isi tabel Anda
 			// 		const produk = cells[1]?.innerText.trim();
 			// 		const recid = cells[1]?.querySelector("input")?.value;
 			// 		const jumlah = cells[2]?.querySelector("input")?.value;
 			// 		const harga = cells[3]?.querySelector("input")?.value;
 			// 		const total = cells[4]?.querySelector("input")?.value;

 			// 		data.push({
 			// 			recid: recid,
 			// 			produk: produk,
 			// 			jumlah: jumlah,
 			// 			harga: harga,
 			// 			total: total.replace(/[^0-9]/g, '')
 			// 		});
 			// 	});

 			// 	const table2 = document.getElementById("tbl-inven");
 			// 	const rows2 = table2.querySelectorAll("tbody tr");

 			// 	const data2 = [];
 			// 	rows2.forEach(row => {
 			// 		const cells = row.querySelectorAll("td");
 			// 		// Pastikan urutan sesuai dengan isi tabel Anda
 			// 		const checked = cells[0]?.querySelector("input")?.checked;
 			// 		const recid = cells[0]?.querySelector("input")?.value;
 			// 		const nama_inven = cells[0]?.innerText.trim();
 			// 		const jumlah = cells[1]?.querySelector("input")?.value;

 			// 		data2.push({
 			// 			checked: checked ? 1 : 0,
 			// 			recid: recid,
 			// 			nama_inven: nama_inven,
 			// 			jumlah: jumlah,
 			// 		});
 			// 	});
 			// 	const isPpnChecked = document.getElementById("use_ppn").checked;
 			// 	const isfree_ongkirChecked = document.getElementById("free_ongkir").checked;
 			// 	const isgunakan_tagihanChecked = document.getElementById("gunakan_tagihan").checked;
 			// 	const isuse_inventarisChecked = document.getElementById("use_inventaris").checked;
 			// 	const detailTambahan = {
 			// 		useppn: isPpnChecked ? 1 : 0,
 			// 		ppn: $("#ppn_amount").val().replace(/[^0-9]/g, ''),
 			// 		freeOngkir: isfree_ongkirChecked ? 1 : 0,
 			// 		ongkir: $("#ongkirNumber").val(),
 			// 		tgl_transaksi: $("#tgl_transaksi").val(),
 			// 		estimasi: $("#estimasi_sampai").val(),
 			// 		bayarDimuka: isgunakan_tagihanChecked ? 1 : 0,
 			// 		jatuh_tempo: $("#jatuh_tempo").val(),
 			// 		use_inventaris: isuse_inventarisChecked ? 1 : 0,
 			// 		client_select: $("#client_select").val(),
 			// 		produksi_select: $("#produksi_select").val(),
 			// 		total_semua: $("#total_bayar").val().replace(/[^0-9]/g, ''),
 			// 	}


 			// 	const payload = {
 			// 		tgl: detailTambahan.tgl_transaksi,
 			// 		no_invoice: $("#jatuh_tempo").val(),
 			// 		harga:

 			// 			dataInventaris: data2.filter(obj => obj.checked === 1),
 			// 		detail: detailTambahan

 			// 	};
 			// 	console.log(payload)
 			// 	fetch("fungsi/tambah/tambah.php?jual=tambah", {
 			// 			method: "POST",
 			// 			headers: {
 			// 				"Content-Type": "application/json"
 			// 			},
 			// 			body: JSON.stringify(payload)
 			// 		})
 			// 		.then(res => res.text())
 			// 		.then(result => {
 			// 			alert("Data berhasil dikirim!");
 			// 			console.log(result);
 			// 		})
 			// 		.catch(error => {
 			// 			console.error("Gagal:", error);
 			// 		});

 			// });
 		});

 		//To select country name
 	</script>