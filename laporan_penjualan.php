<!DOCTYPE html>
<html>
<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
?>

<head>
    <title>Print Laporan Penjualan</title>
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
    $client_id = $_GET['client_id'] ?? null;
    // Konversi tanggal dari format Y-m-d ke d-m-Y
    $tglDariFormatted = $tgl_dari ? date('d-m-Y', strtotime($tgl_dari)) : '-';
    $tglSampaiFormatted = $tgl_sampai ? date('d-m-Y', strtotime($tgl_sampai)) : '-';
    ?>
    <h2>Laporan Penjualan DSE</h2>
    <h4>Period : <?= $tglDariFormatted ?> sampai <?= $tglSampaiFormatted ?></h4>


    <table>
        <thead>
            <tr>
                <th>No Invoice</th>
                <th>Nama Client</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = $lihat->laporan_penjualan_print($tgl_dari, $tgl_sampai, $client_id);

            // Contoh data statis
            // $data = [
            //     ["0010/INV/DSE-07/2025", "PT ABC", "2025-07-10", 1500000, "Belum Lunas"],
            //     ["0011/INV/DSE-07/2025", "PT XYZ", "2025-07-12", 2000000, "Lunas"]
            // ];
            $subtotal = 0;
            $lunas = 0;
            $belum_lunas = 0;
            foreach ($data as $row): ?>

                <tr>
                    <?php
                    // isi tabel tergantung jenis

                    // Konversi tanggal jatuh tempo ke objek DateTime
                    $jatuhTempo = strtotime($row['tgl_jatuh_tempo']);
                    $hariIni = strtotime(date('Y-m-d'));

                    // Cek apakah sudah jatuh tempo
                    $isJatuhTempo = $jatuhTempo == $hariIni || $jatuhTempo < $hariIni;

                    // Tambahkan class style jika sudah jatuh tempo
                    $tdStyle = $row['status_pembayaran'] == 0 ? $isJatuhTempo ? 'style="background-color:red; color:white;"' : '' : '';
                    if ($row['status_pembayaran'] == 0) {
                        $belum_lunas += $row['total_harga'];
                    } else {
                        $lunas += $row['total_harga'];
                    }
                    echo "<td>{$row['no_invoice']}</td>
                              <td>{$row['nama_client']}</td>
                              <td>" . date('d-m-Y', strtotime($row['tgl'])) . "</td>
                              <td>Rp " . number_format($row['total_harga']) . "</td>
                              <td>{$row['status_bayar']}</td>
                              <td $tdStyle>" . $row['jatuh_tempo'] . "</td>";

                    $subtotal += $row['total_harga'];

                    ?>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="3" style="text-align:right">Sub Total</th>
                <th colspan="3">Rp <?= number_format($subtotal) ?></th>
            </tr>
            <tr>
                <th colspan="3" style="text-align:right">Lunas</th>
                <th colspan="3">Rp <?= number_format($lunas) ?></th>
            </tr>
            <tr>
                <th colspan="3" style="text-align:right">Belum Lunas</th>
                <th colspan="3">Rp <?= number_format($belum_lunas) ?></th>
            </tr>
        </tbody>
    </table>

</body>

</html>