 <!--sidebar end-->

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
 <!--main content start-->
 <?php

    $id = $_GET['no_invoice'];
    // $id = $_SESSION['admin']['username'];
    $dataPenjualanSelect = $lihat->transaksi_detail_penjualan($id);
    $dataProductSelect = $lihat->detail_transaksi_product($id);
    // $numbeq = $lihat->numberSequenceForTransaksi();
    $dataBahanBakuUntukFormulasi = $lihat->dataBahanBakuUntukFormulasi();

    ?>
 <h4>Penjualan</h4>
 <!-- <input type="hidden" class="form-control" id="invoice" value="<? echo $numbeq; ?>"> -->
 <input type="hidden" class="form-control" id="username" value="<? echo $id; ?>">
 <br>
 <div class="row">
     <!-- <div class="col-sm-12" id="daftar-produk">
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
                                         <?php if ($isi['status'] == 1) { ?>
                                             <button class="btn btn-warning btn-xs add-row-trigger"
                                                 data-id="<?= $isi['recid']; ?>"
                                                 data-nama="<?= $isi['nama_product']; ?>"
                                                 data-desc="<?= $isi['desc_product']; ?>"
                                                 data-grade="<?= $isi['grade']; ?>"
                                                 data-level="<?= $isi['level']; ?>">Tambah ke transaksi</button>
                                         <?php } ?>
                                     </td>
                                 </tr>
                             <?php $no++;
                                } ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div> -->


     <div class="col-sm-12 mb-2">
         <div class="card card-primary">
             <div class="card-header bg-success text-white font-weight-bold">
                 <div class="row">
                     <div class="col-sm-2">
                         <h5>No Invoice</h5>
                     </div>
                     <div class="col-sm-8">
                         : <?php echo $id; ?>
                     </div>
                     <div class="col-sm-2 text-right">
                         <a id="print" href="invoice.php?page=invoice&inv=<?= $id; ?>" target="_blank">
                             <button
                                 class="btn btn-secondary">
                                 🖨 Print Invoice
                             </button>
                         </a>
                     </div>
                 </div>
             </div>
         </div>

     </div>
     <div class="col-sm-12">
         <div class="card card-primary" id="transaksi_semua">
             <div class="card-header bg-primary text-white">
                 <h5><i class="fa fa-shopping-cart"></i> Transaksi
                     <!-- <a class="btn btn-danger float-right"
                         onclick="javascript:return confirm('Apakah anda ingin reset keranjang ?');" href="fungsi/hapus/hapus.php?penjualan=jual">
                         <b>RESET FORM</b></a> -->
                 </h5>
             </div>
             <div class="card-body">
                 <div id="keranjang" class="table-responsive">
                     <table class="table table-bordered">
                         <tr>
                             <td><b>Tanggal</b></td>
                             <!-- <td><input type="text" id="tgl_transaksi" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i"); ?>" name="tgl"></td> -->
                             <td><input type="text" id="tgl_transaksi" readonly="readonly" class="form-control" value="<?php echo date('d F Y', strtotime($dataPenjualanSelect['tgl'])); ?>" name="tgl"></td>
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
                                 <!-- <td> Aksi</td> -->
                             </tr>
                         </thead>
                         <!-- <tbody>

                         </tbody> -->
                         <tbody>
                             <?php
                                // $hasil = $lihat->dataProductSelect();
                                $no = 1;
                                foreach ($dataProductSelect as $isi) {
                                ?>
                                 <tr
                                     data-id="<?= $no; ?>"
                                     data-harga="<?= $isi['hargaPerTon'] ?>"
                                     data-recid="<?= $isi['recid'] ?>"
                                     data-recidproduct="<?= $isi['recid'] ?>"
                                     data-hargabyqty="<?= intval($isi['total_harga']) ?>"
                                     data-qty="<?= str_replace('.', ',', number_format($isi['qty'], 1)); ?>">
                                     <td><?= $no; ?></td>
                                     <td><?= $isi['nama_product']; ?></td>
                                     <td>
                                         <?= str_replace('.', ',', number_format($isi['qty'], 1)); ?>
                                     </td>
                                     <td>Rp <?= number_format($isi['hargaPerTon'], 0, ',', '.') ?></td>
                                     <td>Rp <?= number_format($isi['total_harga'], 0, ',', '.') ?></td>
                                 </tr>
                             <?php $no++;
                                } ?>
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
                                         <input class="form-check-input" type="hidden" id="use_ppn_value" value="<?php echo intval($dataPenjualanSelect['ppn']); ?>">
                                         <input class="form-check-input" type="checkbox" id="use_ppn" disabled>
                                         <label class="form-check-label" for="use_ppn">
                                             Gunakan PPn 11%
                                         </label>
                                     </div>
                                     <div class="form-group mt-2">
                                         <label for="ppn_amount">PPn (11%)</label>
                                         <input type="text" class="form-control" id="ppn_amount" readonly value="Rp <?php echo number_format($dataPenjualanSelect['ppn']); ?>">
                                     </div>
                                 </div>

                                 <!-- Ongkir -->
                                 <div class="col-md-6">
                                     <div class="form-check">
                                         <input class="form-check-input" type="hidden" id="free_ongkir_value" value="<?php echo intval($dataPenjualanSelect['penanggung_ongkir']); ?>">
                                         <input class="form-check-input" type="checkbox" id="free_ongkir" disabled>
                                         <label class="form-check-label" for="free_ongkir">
                                             Ongkir ditanggung perusahaan (Gratis)
                                         </label>
                                     </div>
                                     <div class="form-group mt-2">
                                         <label for="ongkir">Biaya Ongkir</label>
                                         <input type="text" class="form-control" id="ongkir" value="Rp <?php echo number_format($dataPenjualanSelect['ongkir']); ?>">
                                         <input type="hidden" class="form-control" id="ongkirNumber" value="0">
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                                 <!-- Estimasi sampai -->
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="estimasi_sampai">Estimasi Tanggal Sampai</label>
                                         <input type="date" disabled class="form-control" id="estimasi_sampai" value="<?php echo $dataPenjualanSelect['tanggal_sampai']; ?>">
                                     </div>
                                 </div>

                                 <!-- Jatuh tempo -->
                                 <div class="col-md-6">
                                     <div class="form-check">

                                         <input class="form-check-input" type="hidden" id="gunakan_tagihan_value" value="<?php echo $dataPenjualanSelect['tgl_jatuh_tempo']; ?>">
                                         <input class="form-check-input" type="checkbox" id="gunakan_tagihan" disabled>
                                         <label class="form-check-label" for="gunakan_tagihan">
                                             Menggunakan Tagihan (Bukan Pembayaran di Muka)
                                         </label>
                                     </div>
                                     <div class="form-group mt-2">
                                         <label for="jatuh_tempo">Tanggal Jatuh Tempo</label>
                                         <input type="date" class="form-control" disabled id="jatuh_tempo">
                                     </div>
                                 </div>
                             </div>

                             <!-- Inventaris -->
                             <div class="form-check mt-3">
                                 <input class="form-check-input" type="hidden" id="use_inventaris_value" value="<?php echo $dataPenjualanSelect['pakai_inventaris']; ?>">
                                 <input class="form-check-input" type="checkbox" id="use_inventaris" disabled>
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
                                            foreach ($inventarisList as $inv) {
                                                $isChecked = ($dataPenjualanSelect['inven_id'] == $inv['recid']);
                                                $jumlah = $isChecked ? $dataPenjualanSelect['jml_inven'] : 0;
                                            ?>
                                             <tr>
                                                 <td>
                                                     <input
                                                         disabled
                                                         data-value="<?= $dataPenjualanSelect['inven_id'] ?>"
                                                         type="checkbox"
                                                         name="inventaris_id[]"
                                                         value="<?= $inv['recid'] ?>"
                                                         <?= $isChecked ? 'checked' : '' ?>>
                                                     <?= $inv['nama_inven'] ?>
                                                 </td>
                                                 <td>
                                                     <input
                                                         disabled
                                                         type="number"
                                                         name="inventaris_qty[<?= $inv['recid'] ?>]"
                                                         class="form-control"
                                                         value="<?= $jumlah ?>"
                                                         min="0">
                                                 </td>
                                             </tr>
                                         <?php } ?>

                                     </tbody>
                                 </table>
                             </div>

                             <div class="row">
                                 <!-- Client -->
                                 <div class="col-md-6">
                                     <label for="client_select">Pilih Client</label>
                                     <select id="client_select" class="form-control" disabled>
                                         <?php $clients = $lihat->clietList();
                                            foreach ($clients as $c) {
                                                $isSelected = ($dataPenjualanSelect['client_id'] == $c['recid'])
                                            ?>
                                             <option
                                                 value="<?= $c['recid'] ?>"
                                                 <?= $isSelected ? 'selected' : '' ?>>
                                                 <?= $c['nama_client'] ?>
                                             </option>
                                         <?php } ?>
                                     </select>
                                 </div>

                                 <!-- Tempat Produksi -->
                                 <div class="col-md-6">
                                     <label for="produksi_select">Pilih Tempat Produksi</label>
                                     <select id="produksi_select" class="form-control" disabled>
                                         <?php $produksi = $lihat->tmptProduksiList();
                                            foreach ($produksi as $p) {
                                                $isSelected = ($dataPenjualanSelect['tmpt_produksi_id'] == $p['recid'])
                                            ?>
                                             <option value="<?= $p['recid'] ?>"
                                                 <?= $isSelected ? 'selected' : '' ?>>
                                                 <?= $p['nama'] ?></option>
                                         <?php } ?>
                                     </select>
                                 </div>
                             </div>
                             <!-- <div class="row">
 								<div class="col-md-6">
 									<div class="form-check">
 										<input class="form-check-input" type="checkbox" id="use_sewatempat">
 										<label class="form-check-label" for="use_sewatempat">
 											Sewa Tempat Produksi
 										</label>
 									</div>
 									<div class="form-group mt-2">
 										<label for="ppn_amount">Harga Jasa Produksi</label>
 										<input type="text" class="form-control" id="jasa_amount" readonly value="Rp 0">
 										<input type="hidden" class="form-control" id="jasa_amount_hidden" value="0">
 									</div>
 								</div>

 							</div> -->
                         </div>
                     </div>
                 </div>
                 <br />
                 <div id="kasirnya">
                     <table class="table table-stripped">

                         <!-- aksi ke table nota -->

                         <tr>
                             <td>Total Semua </td>
                             <td><input disabled type="text" class="form-control" name="total" id="total_bayar" value="Rp <?php echo number_format($dataPenjualanSelect['total_bayar']); ?>" /></td>

                             </td>
                         </tr>
                         <!-- aksi ke table nota -->
                         <!-- <tr>
                             <td>
                                 <button class="btn btn-success" id="submitAllInput"><i class="fa fa-shopping-cart"></i> Cetak Invoice</button>
                             </td>
                         </tr> -->
                     </table>
                     <br />
                     <br />
                 </div>
             </div>
         </div>
     </div>
     <!-- <div class="card mt-4" id="previewBahanBakuCard" style="display: none;"> -->
     <div class="card mt-4" id="previewBahanBakuCard">
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
                             <th>Harga Beli Bahan Baku</th>
                             <th>Harga Jual Bahan Baku</th>
                             <th>Kebutuhan Total (satuan)</th>
                             <!-- <th>Stok Tersedia (satuan)</th> -->
                             <!-- <th>Status</th> -->
                             <!-- <th>Aksi</th> -->
                         </tr>
                     </thead>
                     <tbody>
                         <!-- Isi otomatis oleh JS -->
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
     <div class="card mt-4" id="databahanbaku" style="display: none;">
         <!-- <div class="card mt-4" id="databahanbaku"> -->
         <div class="card-header bg-warning text-dark">
             <h5><i class="fa fa-cubes"></i>Bahan Baku</h5>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-bordered" id="databahanbakuTable">
                     <thead>
                         <tr>
                             <th>No</th>
                             <th>Nama Bahan Baku</th>
                             <th>Satuan</th>
                             <th>Harga Beli</th>
                             <th>Harga Jual (Modal)</th>
                             <th>Kebutuhan Total</th>
                             <th>Stok Tersedia</th>
                         </tr>
                     </thead>
                     <tbody>

                         <?php

                            $no = 1;
                            foreach ($dataBahanBakuUntukFormulasi as $isi) {
                            ?>
                             <tr
                                 data-bahanbakuid="<?= $isi['bahanbaku_id']; ?>"
                                 data-id="<?= $no; ?>"
                                 data-nama="<?= $isi['nama_bahan'] ?>"
                                 data-kebutuhan="<?= $isi['kebutuhan'] ?>"
                                 data-stok="<?= $isi['stok']; ?>"
                                 data-uom="<?= $isi['uom']; ?>"
                                 data-hargabeli="<?= $isi['harga_beli']; ?>"
                                 data-hargamodal="<?= $isi['harga_pasaran_per_satuan']; ?>"
                                 data-bahanbakuid="<?= $isi['bahanbaku_id']; ?>"
                                 data-produkid="<?= $isi['produk_id']; ?>">
                                 <td><?= $no; ?></td>
                                 <td><?= $isi['nama_bahan']; ?></td>
                                 <td><?= $isi['uom']; ?></td>
                                 <td><?= $isi['harga_beli']; ?></td>
                                 <td><?= $isi['harga_pasaran_per_satuan']; ?></td>
                                 <td><?= $isi['kebutuhan']; ?></td>
                                 <td><?= $isi['stok']; ?></td>
                             </tr>
                         <?php $no++;
                            } ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

 </div>


 <script>
     // AJAX call for autocomplete 
     $(document).ready(function() {

         function getDatabahanFormulasidanStok() {
             var semuaData = [];

             $('#databahanbakuTable tbody tr').each(function() {
                 var rowData = {
                     id: $(this).data('id'),
                     bahanbakuid: $(this).data('bahanbakuid'),
                     produkid: $(this).data('produkid'),
                     nama: $(this).data('nama'),
                     kebutuhan: $(this).data('kebutuhan'),
                     hargabeli: $(this).data('hargabeli'),
                     hargamodal: $(this).data('hargamodal'),
                     stok: $(this).data('stok'),
                     uom: $(this).data('uom')
                 };

                 semuaData.push(rowData);
             });

             return semuaData;
         }


         function loadPreviewBahanBaku() {
             const kebutuhan = {};
             let totalHargabeli = 0;
             let totalHargaModal = 0;
             let totalPenjualan = 0;
             const rows = document.querySelectorAll('#table2 tbody tr');

             if (rows.length === 0) {
                 console.log("Tidak ada baris di tabel.");
                 return;
             }

             const dataFormulasi = getDatabahanFormulasidanStok();
             console.log(rows);
             rows.forEach(row => {
                 const idProduct = row.dataset.recid;
                 //  const hargaInput = row.querySelector('td:nth-child(5) input'); // harga produk
                 const hargaInput = row.dataset.hargabyqty; // harga produk
                 const qtyInput = row.dataset.qty;
                 const qty = parseFloat(qtyInput.replace(',', '.'));
                 const harga = parseFloat(hargaInput);
                 var x = {
                     idProduct,
                     qty,
                     harga,
                     hargaInput
                 }
                 console.log(x);
                 console.log('Qty:', qty, '| Harga:', harga, 'hargainpuit:', hargaInput, "data:", dataFormulasi);

                 if (!idProduct || qty <= 0 || harga <= 0) return;

                 totalPenjualan += harga;

                 dataFormulasi.forEach(item => {
                     if (item.produkid === parseInt(idProduct)) {
                         if (!kebutuhan[item.nama]) {
                             kebutuhan[item.nama] = {
                                 total_kebutuhan: 0,
                                 hargabeli: 0,
                                 hargamodal: 0,
                                 stok: item.stok,
                                 uom: item.uom,
                                 recid: item.bahanbakuid,
                             };
                         }
                         kebutuhan[item.nama].total_kebutuhan += item.kebutuhan * qty;
                         const subtotal = item.hargamodal * qty;
                         kebutuhan[item.nama].hargamodal += subtotal;
                         const subtotalbeli = item.hargabeli * qty;
                         kebutuhan[item.nama].hargabeli += subtotalbeli;
                         totalHargaModal += subtotal;
                         totalHargabeli += subtotalbeli;
                     }
                 });
             });
             // Tampilkan hasil
             const $tbody = $('#previewBahanBakuTable tbody');
             $tbody.empty();
             let no = 1;
             for (const nama in kebutuhan) {
                 const bb = kebutuhan[nama];
                 const kurang = bb.stok < bb.total_kebutuhan;
                 const status = kurang ? 'Stok Kurang' : 'Cukup';
                 const row = `
			<tr data-recid="${bb.recid}">
				<td>${no++}</td>
				<td>${nama}</td>
				<td>Rp ${bb.hargabeli.toLocaleString()}</td>
				<td>Rp ${bb.hargamodal.toLocaleString()}</td>
				<td>${bb.total_kebutuhan.toFixed(2)} (${bb.uom})</td>
			</tr>`;
                 $tbody.append(row);
             }

             // Tambahkan baris total harga modal & profit
             if (no > 1) {
                 const totalProfit = totalPenjualan - totalHargaModal;
                 const totalProfitBeli = totalHargaModal - totalHargabeli;
                 const summaryRows = `
			<tr style="font-weight: bold; background-color: #f0f0f0;">
				<td colspan="2">Total Harga Modal</td>
				<td colspan="5">Rp ${totalHargaModal.toLocaleString()}</td>
			</tr>
			<tr style="font-weight: bold; background-color: #e0ffe0;">
				<td colspan="2">Total Penjualan</td>
				<td colspan="5">Rp ${totalPenjualan.toLocaleString()}</td>
			</tr>
			<tr style="font-weight: bold; background-color: #d0f0ff;">
				<td colspan="2">Total Profit Penjualan Product</td>
				<td colspan="5">Rp ${totalProfit.toLocaleString()}</td>
			</tr>
			<tr style="font-weight: bold; background-color: #d0f0ff;">
				<td colspan="2">Total Profit Penjualan Bahan Baku</td>
				<td colspan="5">Rp ${totalProfitBeli.toLocaleString()}</td>
			</tr>
		`;
                 console.log(summaryRows);
                 $tbody.append(summaryRows);
                 $('#previewBahanBakuCard').show();
             } else {
                 $('#previewBahanBakuCard').hide();
             }
         }

         //PPN
         if ($('#use_ppn_value').val() != '0') {
             $('#use_ppn').prop('checked', true);
         } else {
             $('#use_ppn').prop('checked', false);
         }
         //ONGKIR
         if ($('#free_ongkir_value').val() != '0') {
             $('#free_ongkir').prop('checked', true);
         } else {
             $('#free_ongkir').prop('checked', false);
         }
         //tagihan
         function updateTagihanState() {
             const value = $('#gunakan_tagihan_value').val();

             if (value) {
                 // Jika value tidak null/kosong
                 $('#gunakan_tagihan').prop('checked', true);
                 $('#jatuh_tempo').val(value);
             } else {
                 // Jika value null atau kosong
                 $('#gunakan_tagihan').prop('checked', false);
                 $('#jatuh_tempo').val('');
             }
         }

         // Panggil saat halaman dimuat
         updateTagihanState();
         $('#gunakan_tagihan_value').on('change', function() {
             updateTagihanState();
         });

         if ($('#use_inventaris_value').val() != '0') {
             $('#use_inventaris').prop('checked', true);
             $('#inventaris_options').toggle(this.checked);
         } else {
             $('#use_inventaris').prop('checked', false);
         }




         // sementara

         setTimeout(loadPreviewBahanBaku, 1000);

     });

     //To select country name
 </script>