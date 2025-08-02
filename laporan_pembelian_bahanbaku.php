<!DOCTYPE html>
<html>
<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
?>

<head>
    <title>Print Laporan Pembelian Bahan Baku</title>
    <style>
        @media print {
            @page {
                size: landscape;
            }

            .no-print {
                display: none;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }
        }

        table {
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .print-button {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button class="print-button" onclick="window.print()">🖨 Print Laporan</button>
    </div>
    <?php
    $tgl_dari = $_GET['from'] ?? null;
    $tgl_sampai = $_GET['to'] ?? null;
    // Konversi tanggal dari format Y-m-d ke d-m-Y
    $tglDariFormatted = $tgl_dari ? date('d-m-Y', strtotime($tgl_dari)) : '-';
    $tglSampaiFormatted = $tgl_sampai ? date('d-m-Y', strtotime($tgl_sampai)) : '-';
    ?>
    <h2>Laporan Pembelian Bahan Baku DSE</h2>
    <h4>Period : <?= $tglDariFormatted ?> sampai <?= $tglSampaiFormatted ?></h4>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No.PO</th>
                <!-- <th>No.INVOICE</th> -->
                <th>Nama Supplier</th>
                <th>Nama Bahan Baku</th>
                <th>Qty</th>
                <th>UOM</th>
                <th>Status</th>
                <th>Status Pembayaran</th>
                <th>Jumlah Pembayaran</th>
                <!-- <th>Harga</th> -->
                <th>Qty Aktual</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = $lihat->laporan_pembelian_bahan_baku($tgl_dari, $tgl_sampai);

            $subtotal = 0;
            $lunas = 0;
            $belum_lunas = 0;
            foreach ($data as $row): ?>
                <?php
                $tdStyle = $row['status_pembayaran'] != "Lunas" ? 'style="background-color:red; color:white;"' : '';

                echo "<tr $tdStyle>";
                ?>
                <td><?= $no++ ?></td>
                <?php
                echo "<td>" . date('d-m-Y', strtotime($row['tgl'])) . "</td>
                    <td>{$row['no_po']}</td>
              <td>{$row['nama_supplier']}</td>
              <td>{$row['nama_bb']}</td>
              <td>{$row['qty']}</td>
              <td>{$row['kode_uom']}</td>
              <td>{$row['status']}</td>
              <td>{$row['status_pembayaran']}</td>
              <td>Rp " . number_format($row['jumlah_bayar']) . "</td>
              <td>{$row['qty_terima']}</td>";

                $subtotal += $row['jumlah_bayar'];
                ?>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="9" style="text-align:right">Sub Total</th>
                <th colspan="3">Rp <?= number_format($subtotal) ?></th>
            </tr>
        </tbody>
    </table>

</body>

</html>