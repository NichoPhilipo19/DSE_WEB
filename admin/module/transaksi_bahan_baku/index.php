<?php
    // contoh ambil data dari database
    $transaksi = $lihat->transaksi_bahanbaku_list();
?>
    <h4 class="mb-4">Transaksi Bahan Baku</h4>
    
    <!-- Tombol tambah -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus"></i> Buat PO Bahan Baku
    </button>

    <!-- Tabel -->
    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Bahan Baku</th>
                        <th>Jenis</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($transaksi as $row): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                            <td><?= $row['nama_bb'] ?></td>
                            <td>
                                <span class="badge badge-<?= $row['jenis'] == 'masuk' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($row['jenis']) ?>
                                </span>
                            </td>
                            <td><?= $row['qty'] ?></td>
                            <td><?= $row['nama_uom'] ?></td>
                            <td><?= $row['keterangan'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
